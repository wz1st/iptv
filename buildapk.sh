#!/bin/sh


SYNOPKG_PKGNAME="iptv"
PACKAGE_BASE="/build"
IPTV_WEB_SOURCE="${PACKAGE_BASE}/iptv"
IPTV_CLIENT_SOURCE="${PACKAGE_BASE}/client"
APKTOOL_PATH="${PACKAGE_BASE}/apktool"
IPTV_WEB_SER="/var/www/html/${SYNOPKG_PKGNAME}"
DATE=$(date +%Y.%m.%d)

export JAVA_HOME=$PACKAGE_BASE/java
export PATH=$JAVA_HOME/bin:$JAVA_HOME/jre/bin:$PATH
export CLASSPATH=.:$JAVA_HOME/lib:$JAVA_HOME/jre/lib
JAVA="${PACKAGE_BASE}/java/bin/java"

if [ "$#" -lt 3 ]; then
    PROTOCOL=$PROTOCOL
    IPTV_SER_PORT=$IPTV_SER_PORT
    IPTV_SER_ADDR=$IPTV_SER_ADDR
else
    PROTOCOL=$1
    IPTV_SER_ADDR=$2
    IPTV_SER_PORT=$3
fi

if [ "${PROTOCOL}" = "http" ] || [ "${PROTOCOL}" = "https"]; then
    PROTOCOL=$PROTOCOL
else
    PROTOCOL="http"
fi

if [ "${IPTV_SER_PORT}" = "80" ] || [ "${IPTV_SER_PORT}" = "443" ]; then
    IPTV_SER_PORT=""
else
    IPTV_SER_PORT=":${IPTV_SER_PORT}"
fi

IPTV_SER_HOST="${PROTOCOL}:\/\/${IPTV_SER_ADDR}${IPTV_SER_PORT}"
sed -i 's/\(const-string\ v0,\ \"\).*\/iptv/\1'"${IPTV_SER_HOST}"'\/iptv/g' "${IPTV_CLIENT_SOURCE}/smali/com/eztv/powerful/PlayerActivity.smali"
sed -i 's/\(const-string\ v0,\ \"\).*\/iptv/\1'"${IPTV_SER_HOST}"'\/iptv/g' "${IPTV_CLIENT_SOURCE}/smali/com/eztv/powerful/SplashActivity.smali"
"${JAVA}" -Djava.io.tmpdir="${PACKAGE_BASE}/temp" -jar "${APKTOOL_PATH}/apktool.jar" b "${IPTV_CLIENT_SOURCE}" -o "${PACKAGE_BASE}/temp/unsignapk.apk" > /dev/null && "${JAVA}" -jar "${APKTOOL_PATH}/SignApk/signapk.jar" "${APKTOOL_PATH}/SignApk/certificate.pem" "${APKTOOL_PATH}/SignApk/key.pk8" "${PACKAGE_BASE}/temp/unsignapk.apk" "${IPTV_WEB_SOURCE}/app/DSMTV.apk"
sed -i 's/\(versionTime:\ \).*\,/\1'"'${DATE}'"'\,/g' "${IPTV_WEB_SER}/js/versionUpdate.js"
CM=`ls -l "${IPTV_WEB_SOURCE}/app/DSMTV.apk" | awk '{printf "%0.2f\n",$5/1048576}'`
sed -i 's/\(versionSize:\ \).*\,/\1'"'${CM}MB'"'\,/g' "${IPTV_WEB_SER}/js/versionUpdate.js"
mv -f "${IPTV_WEB_SOURCE}/app/DSMTV.apk" "${IPTV_WEB_SER}/app/"
rm -rf "${IPTV_CLIENT_SOURCE}/build" "${PACKAGE_BASE}/temp"/*