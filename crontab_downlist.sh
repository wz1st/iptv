#!/bin/bash
# iptv_update_scheduler.sh
# 每分钟检查是否需要自动更新 IPTV，并按 updateinterval 执行更新

DB_USER="root"
DB_PASS="root"
DB_NAME="iptv"

# 封装函数：执行 SQL
run_sql() {
    mysql -u"$DB_USER" -p"$DB_PASS" -D"$DB_NAME" -N -e "$1"
}

# 封装函数：导入频道列表
add_channel_list() {
    local cname="$1"
    local listfile="$2"
    local repeat=0
    echo "🔄 导入分类 [$cname] ..."

    run_sql "DELETE FROM iptv_channels WHERE category='${cname}';"

    CLEAN_FILE=$(mktemp)
    cat "$listfile" \
        | sed 's/\r//g' \
        | sed 's/[[:space:]]//g' \
        | sed 's/#genre#//g' \
        | sed 's/ver\..*\.m3u8//g' \
        | sed 's/t\.me.*\.m3u8//g' \
        | sed 's/https.*www\.bbsok\.cf[^>]*//g' \
        > "$CLEAN_FILE"

    while IFS= read -r line; do
        if [[ "$line" == *","* ]]; then
            cname2="${line%%,*}"
            sources="${line#*,}"
            IFS='#' read -ra urls <<< "$sources"
            for src in "${urls[@]}"; do
                url=$(echo "$src" | sed 's/["{}'\'' ]//g')
                if [ -n "$cname2" ] && [ -n "$url" ]; then
                    exists=$(run_sql "SELECT COUNT(*) FROM iptv_channels WHERE url='${url}';")
                    if [ "$exists" -gt 0 ]; then
                        ((repeat++))
                    else
                        run_sql "INSERT INTO iptv_channels(name,url,category) VALUES('${cname2}','${url}','${cname}');"
                    fi
                fi
            done
        fi
    done < "$CLEAN_FILE"
    rm -f "$CLEAN_FILE"
    echo "✅ [$cname] 导入完成，跳过重复 $repeat 条"
}

# 核心循环：每分钟检查 autoupdate
while true; do
    AUTOUPDATE=$(run_sql "SELECT value FROM iptv_config WHERE name='autoupdate';")
    if [ "$AUTOUPDATE" != "1" ]; then
        echo "$(date '+%F %T') ⏸️ 自动更新未开启，跳过..."
        sleep 60
        continue
    fi

    UPDATEINTERVAL=$(run_sql "SELECT value FROM iptv_config WHERE name='updateinterval';")
    UPDATEINTERVAL=${UPDATEINTERVAL:-10}  # 默认10分钟

    echo "$(date '+%F %T') ⏳ 开始 IPTV 更新，间隔 $UPDATEINTERVAL 分钟"

    # 遍历所有分类
    CATEGORIES=$(run_sql "SELECT name FROM iptv_category;")
    for CATEGORY in $CATEGORIES; do
        echo "=============================="
        echo "📂 处理分类: $CATEGORY"

        row=$(run_sql "SELECT url, autocategory FROM iptv_category WHERE name='${CATEGORY}' LIMIT 1;")
        listurl=$(echo "$row" | awk '{print $1}')
        autocategory=$(echo "$row" | awk '{print $2}')

        if [ -z "$listurl" ]; then
            echo "❌ 分类 [$CATEGORY] 未设置 url"
            continue
        fi

        TMPFILE=$(mktemp)
        curl -s --max-time 15 "$listurl" -o "$TMPFILE"
        if [ ! -s "$TMPFILE" ]; then
            echo "❌ 下载失败: $listurl"
            rm -f "$TMPFILE"
            continue
        fi

        if [ "$autocategory" = "on" ]; then
            if grep -q "#genre#" "$TMPFILE"; then
                echo "📑 [$CATEGORY] 检测到分组，按 #genre# 拆分 ..."
                awk -v parent="$CATEGORY" '
                /^#genre#/ {
                    g=substr($0,8)
                    gsub(/[ \t]+/, "", g)
                    genre=g
                    next
                }
                {
                    if (genre != "") {
                        print $0 >> ("/tmp/genre_" genre ".txt")
                    }
                }' "$TMPFILE"

                for f in /tmp/genre_*.txt; do
                    genreName=$(basename "$f" | sed 's/genre_//;s/.txt//')
                    categoryName="${genreName}(${CATEGORY})"
                    exists=$(run_sql "SELECT COUNT(*) FROM iptv_category WHERE name='${categoryName}';")
                    if [ "$exists" -eq 0 ]; then
                        echo "➕ 新增分类 $categoryName"
                        run_sql "INSERT INTO iptv_category(name,autocategory) VALUES('${categoryName}','${CATEGORY}');"
                    fi
                    add_channel_list "$categoryName" "$f"
                    rm -f "$f"
                done
            else
                echo "⚠️ [$CATEGORY] 未发现 #genre#，关闭自动分类"
                run_sql "UPDATE iptv_category SET autocategory=NULL WHERE name='${CATEGORY}';"
                add_channel_list "$CATEGORY" "$TMPFILE"
            fi
        else
            echo "🔄 普通更新 [$CATEGORY]"
            add_channel_list "$CATEGORY" "$TMPFILE"
        fi

        rm -f "$TMPFILE"
    done

    run_sql "SET @i=0; UPDATE iptv_category SET id=(@i:=@i+1) ORDER BY id;"
    echo "🎉 IPTV 更新完成，等待 $UPDATEINTERVAL 分钟后再次执行"

    sleep "$((UPDATEINTERVAL * 60))"
done
