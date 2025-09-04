#!/bin/sh
set -e

cleanup() {
    echo "检测到 Ctrl+C，正在退出..."
    exit 0
}

trap cleanup SIGINT

mkdir -p /var/lib/mysql /run/mysqld
chown -R mysql:mysql /var/lib/mysql /run/mysqld
MYSQLPWD=root

APP_NAME="IPTV"
APP_PNAME="cn.dsmtv.player"
KEYSTORE_PASS="123456"

IPTV_CLIENT_SOURCE="/client"

# 如果数据目录为空，则初始化数据库
if [ ! -d "/var/lib/mysql/mysql" ]; then
    echo "初始化 MariaDB 数据库..."
    mysql_install_db --user=mysql --datadir=/var/lib/mysql > /dev/null 2>&1
    mariadbd --datadir=/var/lib/mysql --socket=/run/mysqld/mysqld.sock --user=mysql > /dev/null 2>&1 & pid=$! 
    until mariadb -u root -S /run/mysqld/mysqld.sock -p$MYSQLPWD -e "select 1;" &>/dev/null; do
        sleep 1
    done
    mariadb -u root -S /run/mysqld/mysqld.sock -p$MYSQLPWD -e "CREATE DATABASE IF NOT EXISTS iptv;"
    mariadb -u root -S /run/mysqld/mysqld.sock -p$MYSQLPWD iptv < /var/www/iptv.sql
    mariadb -u root -S /run/mysqld/mysqld.sock -p$MYSQLPWD -e "DROP USER IF EXISTS 'root'@'%';CREATE USER 'root'@'%' IDENTIFIED BY '$MYSQLPWD';GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;"
    mariadb -u root -S /run/mysqld/mysqld.sock -p$MYSQLPWD -e "DROP USER IF EXISTS 'root'@'localhost';CREATE USER 'root'@'localhost' IDENTIFIED BY '$MYSQLPWD';GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' WITH GRANT OPTION;"
    mariadb -u root -S /run/mysqld/mysqld.sock -p$MYSQLPWD -e "FLUSH PRIVILEGES;"

    APP_NAME=$(mariadb -u root -S /run/mysqld/mysqld.sock -p"$MYSQLPWD" -N -B -e "select value from iptv.iptv_config where name='app_appname';")
    APP_PNAME=$(mariadb -u root -S /run/mysqld/mysqld.sock -p"$MYSQLPWD" -N -B -e "select value from iptv.iptv_config where name='app_packagename';")

    kill $pid
else
    echo "MariaDB 数据库已存在，跳过初始化"
    mariadbd --datadir=/var/lib/mysql --socket=/run/mysqld/mysqld.sock --user=mysql > /dev/null 2>&1 & pid=$! 
    until mariadb -u root -S /run/mysqld/mysqld.sock -p$MYSQLPWD -e "select 1;" &>/dev/null; do
        sleep 1
    done
    echo "获取自定义APK信息..."
    APP_NAME=$(mariadb -u root -S /run/mysqld/mysqld.sock -p"$MYSQLPWD" -N -B -e "select value from iptv.iptv_config where name='app_appname';")
    APP_PNAME=$(mariadb -u root -S /run/mysqld/mysqld.sock -p"$MYSQLPWD" -N -B -e "select value from iptv.iptv_config where name='app_packagename';")

    kill $pid
fi

if [ ! -f "/var/www/html/iptv/index.php" ]; then
    echo "初始化WEB目录..."
    rm -rf /var/www/html/*
    cp -r /var/www/iptv/* /var/www/html/
    chown -R nginx:nginx /var/www/html
    chmod -R 755 /var/www/html
    echo "WEB目录初始化完成"
else
    echo "WEB目录已存在，跳过初始化"
fi

echo "APK编译..."

timestamp=$(date +%s)
PACKAGE_BASE="/tmp/build_$timestamp"

BUILD_SOURCE="${PACKAGE_BASE}/client"
IPTV_WEB_SER="/var/www/html"
DATE=$(date +%Y.%m.%d)
OUTPUT_DIR="/var/www/html/app"
mkdir -p "$OUTPUT_DIR"
chmod 777 -R "$OUTPUT_DIR"
OUTPUT_APK="$OUTPUT_DIR/${APP_NAME}.apk"

KEYSTORE_PATH="${PACKAGE_BASE}/auto_keystore.jks"
KEY_ALIAS="iptvkey"

mkdir -p "${PACKAGE_BASE}"
cp -rf "$IPTV_CLIENT_SOURCE" "$PACKAGE_BASE"

if [ ! -f "$KEYSTORE_PATH" ]; then
    echo "生成APK签名信息..."
    keytool -genkey -v \
        -keystore "$KEYSTORE_PATH" \
        -alias "$KEY_ALIAS" \
        -keyalg RSA \
        -keysize 2048 \
        -validity 10000 \
        -storepass "$KEYSTORE_PASS" \
        -keypass "$KEYSTORE_PASS" \
        -dname "CN=Auto, OU=Dev, O=Company, L=City, S=State, C=CN" > /dev/null 2>&1
fi

PROTOCOL=$PROTOCOL
IPTV_SER_PORT=$IPTV_SER_PORT
IPTV_SER_ADDR=$IPTV_SER_ADDR

if [ "${IPTV_SER_PORT}" = "80" ] || [ "${IPTV_SER_PORT}" = "443" ]; then
    port=""
else
    port=":${IPTV_SER_PORT}"
fi

IPTV_SER_HOST="${PROTOCOL}:\/\/${IPTV_SER_ADDR}${port}"

echo "更新APK信息：包名=${APP_PNAME} 应用名称=${APP_NAME} "
# 应用包名和应用名称
rename.sh "$BUILD_SOURCE" "$APP_PNAME" "$APP_NAME"

echo "更新服务器地址=${PROTOCOL}://${IPTV_SER_ADDR}${port}"

find "$BUILD_SOURCE/smali" -type f -name "*.smali" -exec sed -i 's/\(const-string\ v0,\ \"\).*\/iptv/\1'"${IPTV_SER_HOST}"'\/iptv/g' {} +

echo "编译APK..."
apktool b "$BUILD_SOURCE" -o "$OUTPUT_APK" 

echo "签名APK..."
jarsigner -verbose -sigalg SHA256withRSA -digestalg SHA-256 \
    -keystore "$KEYSTORE_PATH" \
    -storepass "$KEYSTORE_PASS" \
    -keypass "$KEYSTORE_PASS" \
    "$OUTPUT_APK" "$KEY_ALIAS"  > /dev/null 2>&1

echo "更新版本信息..."
sed -i 's/\(versionTime:\ \).*\,/\1'"'${DATE}'"'\,/g' "${IPTV_WEB_SER}/js/versionUpdate.js"
CM=`ls -l "$OUTPUT_APK" | awk '{printf "%0.2f\n",$5/1048576}'`
sed -i 's/\(versionSize:\ \).*\,/\1'"'${CM}MB'"'\,/g' "${IPTV_WEB_SER}/js/versionUpdate.js"
sed -i "s#\(/app/\)[^\"/]*#\1${APP_NAME}.apk#" "${IPTV_WEB_SER}/js/versionUpdate.js"

echo "编译完成 清理临时文件"
chmod 777 "$OUTPUT_APK"
rm -rf "${PACKAGE_BASE}/"


echo "启动服务..."
exec /usr/bin/supervisord -c /etc/supervisord.conf  >/dev/null 2>&1
