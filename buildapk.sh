#!/bin/sh
set -e

KEYSTORE_PASS="123456"
IPTV_CLIENT_SOURCE="/client"

echo "APK编译..."

timestamp=$(date +%s)
PACKAGE_BASE="/tmp/build_$timestamp"

BUILD_SOURCE="${PACKAGE_BASE}/client"
IPTV_WEB_SER="/var/www/html"
DATE=$(date +%Y.%m.%d)
OUTPUT_APK="/var/www/html/app/IPTV.apk"

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
    IPTV_SER_PORT=""
else
    IPTV_SER_PORT=":${IPTV_SER_PORT}"
fi

IPTV_SER_HOST="${PROTOCOL}:\/\/${IPTV_SER_ADDR}${IPTV_SER_PORT}"

echo "更新服务器地址=${IPTV_SER_HOST_ESCAPED//\\//}"

find "$BUILD_SOURCE/smali" -type f -name "*.smali" -exec sed -i 's/\(const-string\ v0,\ \"\).*\/iptv/\1'"${IPTV_SER_HOST}"'\/iptv/g' {} +

echo "编译APK..."
apktool b "$BUILD_SOURCE" -o "$OUTPUT_APK" > /dev/null 2>&1

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
sed -i "s#\(/app/\)[^\"/]*#\1IPTV.apk#" "${IPTV_WEB_SER}/js/versionUpdate.js"

echo "编译完成 清理临时文件"
rm -rf "${PACKAGE_BASE}/"
