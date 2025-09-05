#!/bin/sh
set -e
MYSQLPWD=root
APP_SIGN="12315"
IPTV_CLIENT_SOURCE="/client"

APP_NAME=$(mariadb -u root -S /run/mysqld/mysqld.sock -p"$MYSQLPWD" -N -B -e "select value from iptv.iptv_config where name='app_appname';")
APP_PNAME=$(mariadb -u root -S /run/mysqld/mysqld.sock -p"$MYSQLPWD" -N -B -e "select value from iptv.iptv_config where name='app_packagename';")
APP_SIGN=$(mariadb -u root -S /run/mysqld/mysqld.sock -p"$MYSQLPWD" -N -B -e "select value from iptv.iptv_config where name='app_sign';")

echo "APK编译..."

timestamp=$(date +%s)
PACKAGE_BASE="/tmp/build_$timestamp"

BUILD_SOURCE="${PACKAGE_BASE}/client"
IPTV_WEB_SER="/var/www/html"
DATE=$(date +%Y.%m.%d)
OUTPUT_DIR="/var/www/html/app"
mkdir -p "$OUTPUT_DIR"
rm -rf "$OUTPUT_DIR/*"
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
        -storepass 123456 \
        -keypass 123456 \
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

HEX=$(printf "0x%x" "$APP_SIGN")
sed -i "s/const\/16 v0, 0x301b/const\/16 v0, $HEX/" $(find "$BUILD_SOURCE/smali" -type f -name "SplashActivity.smali")

echo "打包APK..."
apktool b "$BUILD_SOURCE" -o "$OUTPUT_APK" > /dev/null 2>&1

echo "签名APK..."
jarsigner -verbose -sigalg SHA256withRSA -digestalg SHA-256 \
    -keystore "$KEYSTORE_PATH" \
    -storepass 123456 \
    -keypass 123456 \
    "$OUTPUT_APK" "$KEY_ALIAS"  > /dev/null 2>&1

echo "更新版本信息..."
sed -i 's/\(versionTime:\ \).*\,/\1'"'${DATE}'"'\,/g' "${IPTV_WEB_SER}/js/versionUpdate.js"
CM=`ls -l "$OUTPUT_APK" | awk '{printf "%0.2f\n",$5/1048576}'`
sed -i 's/\(versionSize:\ \).*\,/\1'"'${CM}MB'"'\,/g' "${IPTV_WEB_SER}/js/versionUpdate.js"
sed -i "s#\(/app/\)[^\"/]*#\1${APP_NAME}.apk#" "${IPTV_WEB_SER}/js/versionUpdate.js"
sed -i 's/download="[^"]*\.apk"/download="'"${APP_NAME}"'.apk"/g' "${IPTV_WEB_SER}/index.html"
sed -i 's/download="[^"]*\.apk"/download="'"${APP_NAME}"'.apk"/g' "${IPTV_WEB_SER}/mobile.html"

echo "编译完成 清理临时文件"
rm -rf "${PACKAGE_BASE}/"
