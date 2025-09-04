#!/bin/sh

set -e
# ===============================
# 参数
# ===============================
WORKDIR="$1"
NEW_PACKAGE="$2"
APK_NAME="$3"



OLD_PACKAGE=$(grep 'package=' "$WORKDIR/AndroidManifest.xml" | head -n1 | sed 's/.*package="\([^"]*\)".*/\1/')
if [ -z "$OLD_PACKAGE" ]; then
    echo "[!] 未能获取旧包名，退出"
    exit 1
fi
echo "[*] 旧包名：$OLD_PACKAGE"

YML="$WORKDIR/apktool.yml"
if [ -f "$YML" ]; then
    echo "[*] 修改 apktool.yml renameManifestPackage..."
    sed -i "s#renameManifestPackage:.*#renameManifestPackage: $NEW_PACKAGE#g" "$YML"
fi

echo "[*] 修改 AndroidManifest.xml ..."
sed -i "s/package=\"$OLD_PACKAGE\"/package=\"$NEW_PACKAGE\"/" "$WORKDIR/AndroidManifest.xml"
# 替换所有 android:name="旧包名.xxx" → android:name="新包名.xxx"
sed -i "s#android:name=\"$OLD_PACKAGE.#android:name=\"$NEW_PACKAGE.#g" "$WORKDIR/AndroidManifest.xml"
sed -i "s#<string name=\"app_name\">.*</string>#<string name=\"app_name\">${APK_NAME}</string>#g" "$WORKDIR/res/values/strings.xml"


echo "[*] 修改 smali ..."
OLD_PACKAGE_PATH=$(echo "$OLD_PACKAGE" | tr '.' '/')
NEW_PACKAGE_PATH=$(echo "$NEW_PACKAGE" | tr '.' '/')

if [ -d "$WORKDIR/smali/$OLD_PACKAGE_PATH" ]; then
    mkdir -p "$(dirname "$WORKDIR/smali/$NEW_PACKAGE_PATH")"
    mv "$WORKDIR/smali/$OLD_PACKAGE_PATH" "$WORKDIR/smali/$NEW_PACKAGE_PATH"
fi

if [ -n "$OLD_PACKAGE" ]; then
    find "$WORKDIR/smali" -type f -name "*.smali" -exec sed -i "s/${OLD_PACKAGE//./\\/}/${NEW_PACKAGE//./\\/}/g" {} +
fi
echo "[*] 修改完成！"