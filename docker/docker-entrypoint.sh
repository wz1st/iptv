#!/bin/sh
set -e

mkdir -p /var/lib/mysql /run/mysqld
chown -R mysql:mysql /var/lib/mysql /run/mysqld
MYSQLPWD=root

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

echo "编译APP..."
PACKAGE_BASE="/build"
IPTV_CLIENT_SOURCE="${PACKAGE_BASE}/client"
APKTOOL_PATH="${PACKAGE_BASE}/apktool"
IPTV_WEB_SER="/var/www/html"
DATE=$(date +%Y.%m.%d)

PROTOCOL=$PROTOCOL
IPTV_SER_PORT=$IPTV_SER_PORT
IPTV_SER_ADDR=$IPTV_SER_ADDR
if [ "${IPTV_SER_PORT}" = "80" ] || [ "${IPTV_SER_PORT}" = "443" ]; then
    IPTV_SER_PORT=""
else
    IPTV_SER_PORT=":${IPTV_SER_PORT}"
fi
IPTV_SER_HOST="${PROTOCOL}://${IPTV_SER_ADDR}${IPTV_SER_PORT}"


IPTV_SER_HOST="${PROTOCOL}:\/\/${IPTV_SER_ADDR}${IPTV_SER_PORT}"
sed -i 's/\(const-string\ v0,\ \"\).*\/iptv/\1'"${IPTV_SER_HOST}"'\/iptv/g' "${IPTV_CLIENT_SOURCE}/smali/com/eztv/powerful/PlayerActivity.smali"
sed -i 's/\(const-string\ v0,\ \"\).*\/iptv/\1'"${IPTV_SER_HOST}"'\/iptv/g' "${IPTV_CLIENT_SOURCE}/smali/com/eztv/powerful/SplashActivity.smali"

java -Djava.io.tmpdir="${PACKAGE_BASE}/temp" -jar "${APKTOOL_PATH}/apktool.jar" b "${IPTV_CLIENT_SOURCE}" -o "${PACKAGE_BASE}/temp/unsignapk.apk" > /dev/null 
java -jar "${APKTOOL_PATH}/SignApk/signapk.jar" "${APKTOOL_PATH}/SignApk/certificate.pem" "${APKTOOL_PATH}/SignApk/key.pk8" "${PACKAGE_BASE}/temp/unsignapk.apk" "${IPTV_WEB_SER}/app/DSMTV.apk"

sed -i 's/\(versionTime:\ \).*\,/\1'"'${DATE}'"'\,/g' "${IPTV_WEB_SER}/js/versionUpdate.js"
CM=`ls -l "${IPTV_WEB_SER}/app/DSMTV.apk" | awk '{printf "%0.2f\n",$5/1048576}'`
sed -i 's/\(versionSize:\ \).*\,/\1'"'${CM}MB'"'\,/g' "${IPTV_WEB_SER}/js/versionUpdate.js"

rm -rf "${IPTV_CLIENT_SOURCE}/build" "${PACKAGE_BASE}/temp"/*


# 启动 supervisord
exec /usr/bin/supervisord -c /etc/supervisord.conf
