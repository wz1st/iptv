<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

if ($_SESSION['channeladmin'] == 0) {
    if ($_GET['auto'] == 1) {
        # code...
    }else{
        exit("<script>$.alert({title: '警告',content: '你无权访问此页面。',type: 'orange',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){history.go(-1);}}}});</script>");
    }
} 

?>

<?php
$categorytype = $_GET['type'];
// 对分类进行重新排序
function sort_id() {
    global $categorytype, $db;
    if ($categorytype == 'default') {
        $numCount = 1;
    } else if ($categorytype == 'province') {
        $numCount = 50;
    } else if ($categorytype == 'chinanet') {
        $numCount = 100;
    } else if ($categorytype == 'unicom') {
        $numCount = 150;
    } else if ($categorytype == 'cmcc') {
        $numCount = 200;
    } else if ($categorytype == 'vip') {
        $numCount = 250;
    } 
    $result = $db->mQuery("SELECT * from iptv_category where type=".$db->safeSQLParam($categorytype)." order by id");
    while ($row = mysqli_fetch_array($result)) {
        $name = $row['name'];
        $db->mSet("iptv_category", "id=$numCount", "where name=".$db->safeSQLParam($name));
        unset($name);
        $numCount++;
    } 
    unset($row);
	mysqli_free_result($result);
} 
sort_id();
// 检测上下移的ID参数是否存在
function chk_sort_id() {
    global $categorytype, $minid, $maxid, $db;
    if ($row = $db->mGetRow("iptv_category", "min(id),max(id)", "where type=".$db->safeSQLParam($categorytype))) {
        $minid = $row['min(id)'];
        $maxid = $row['max(id)'];
    } 
} 
chk_sort_id(); 
// 增加频道列表
function add_channel_list($cname, $srclist) {
    global $db;
    if (!empty($srclist && $cname)) {
        $srclist = convert_list_format($srclist); // 转换列表格式
        $db->mDel("iptv_channels", "where category=".$db->safeSQLParam($cname));
        $repetnum = 0;
        $rows = explode("\n", $srclist);
        $rows = preg_replace('# ,#', ',', $rows);
        $rows = preg_replace('#\r#', '', $rows);
        //$rows = preg_replace('/\[.*?\]/', '', $rows);
        $rows = preg_replace('/\s+/', '', $rows);
        $rows = preg_replace('/\#genre\#/', '', $rows);
        $rows = preg_replace('/ver\..*?\.m3u8/', '', $rows);
        $rows = preg_replace('/t\.me.*?\.m3u8/', '', $rows);
        $rows = preg_replace("/https(.*)www.bbsok.cf[^>]*/", "", $rows);
        foreach($rows as $row) {
            if (strpos($row, ',') !== false) {
                $ipos = strpos($row, ',');
                $channelname = substr($row, 0, $ipos);
                $source = substr($row, $ipos + 1);
                if (strpos($source, '#') !== false) {
                    $sources = explode("#", $source);
                    foreach ($sources as $src) {
                        $src2 = str_replace("\"", "", $src);
                        $src2 = str_replace("\'", "", $src2);
                        $src2 = str_replace("}", "", $src2);
                        $src2 = str_replace("{", "", $src2);
                        $channelurl = $db->mQuery("SELECT url from iptv_channels");
                        while ($url = mysqli_fetch_array($channelurl)) {
                            if ($src2 == $url[0]) {
                                $src2 = '';
                                $repetnum++;
                            } 
                        } 
                        unset($url);
                        mysqli_free_result($channelurl);
                        if ($channelname != '' && $src2 != '') {
                            $db->mInt("iptv_channels", "id,name,url,category", "NULL,".$db->safeSQLParam($channelname).",".$db->safeSQLParam($src2).",".$db->safeSQLParam($cname));
                        } 
                    } 
                } else {
                    $src2 = str_replace("\"", "", $source);
                    $src2 = str_replace("\'", "", $src2);
                    $src2 = str_replace("}", "", $src2);
                    $src2 = str_replace("{", "", $src2);
                    $channelurl = $db->mQuery("SELECT url from iptv_channels");
                    while ($url = mysqli_fetch_array($channelurl)) {
                        if ($src2 == $url[0]) {
                            $src2 = '';
                            $repetnum++;
                        } 
                    } 
                    unset($url);
					mysqli_free_result($channelurl);
                    if ($channelname != '' && $src2 != '') {
                        $db->mInt("iptv_channels", "id,name,url,category", "NULL,".$db->safeSQLParam($channelname).",".$db->safeSQLParam($src2).",".$db->safeSQLParam($cname));
                    } 
                } 
            } 
        } 
        unset($rows, $srclist);
        return $repetnum;
    } 
    return -1;
} 
// 获取分类名称
if (isset($_GET['category'])) {
    $cname = $_GET['category'];
} else {
    if ($row = $db->mGetRow("iptv_category", "name", "order by id")) {
        $cname = $row['name'];
        unset($row);
    } else {
        $cname = '';
    } 
} 
// 修改频道列表
if (isset($_POST['submit']) && isset($_POST['category']) && isset($_POST['srclist'])) {
    $cname = $_POST['category'];
    $srclist = $_POST['srclist'];
    $showindex = $_POST['showindex'];
    $listreturn = add_channel_list($cname, $srclist);
    if ($listreturn != -1) {
        echo"<script>showindex=$showindex;lightyear.notify('保存成功！$listreturn 个重复节目源！', 'success', 3000);</script>";
    } else {
        echo"<script>showindex=$showindex;lightyear.notify('保存失败,列表不能为空！', 'danger', 3000);</script>";
    } 
    unset($srclist);
} 

// 增加分类
if (isset($_POST['submit']) && isset($_POST['category'])) {
    $category = $_POST['category'];
    $cpass = $_POST['cpass'];
    if ($category == "") {
        echo "<script>lightyear.notify('类别名称不能为空！', 'danger', 3000);</script>";
    } else {
        $numCount = $maxid + 1;
        $categoryname = $db->mGetRow("iptv_category", "name", "where name=".$db->safeSQLParam($category));
        if (empty($categoryname)) {
            $db->mInt("iptv_category", "id,name,psw,type", "$numCount,".$db->safeSQLParam($category).",".$db->safeSQLParam($cpass).",".$db->safeSQLParam($categorytype));
            $showindex = $db->mGet("iptv_category", "count(*)", "where type=".$db->safeSQLParam($categorytype)) - 1;
            echo "<script>showindex=$showindex;lightyear.notify('增加类别$category 成功！', 'success', 3000);</script>";
            sort_id();
            if (isset($result)) {
                mysqli_free_result($result);
            }
            $cname = $category;
        } 
    } 
}

// 增加外部列表
if (isset($_POST['addthirdlist'])) {
    $category = $_POST['thirdlistcategory'];
    $listurl = $_POST['thirdlisturl'];
    $autocategory = $_POST['autocategory'];  
    if ($category == "") {
        echo "<script>lightyear.notify('类别名称不能为空！', 'danger', 3000);</script>";
    } else {
        $srclist = file_get_contents($listurl);
		$srclist = filterEmoji($srclist);
        $numCount = $maxid + 1;  
        $categoryname = $db->mGetRow("iptv_category", "name", "where name=".$db->safeSQLParam($category));
        if (!empty($categoryname)) {
            $db->mDel("iptv_category", "where name=".$db->safeSQLParam($category));
        }
        $db->mInt("iptv_category", "id,name,psw,type,url,autocategory", "$numCount,".$db->safeSQLParam($category).",".$db->safeSQLParam($cpass).",".$db->safeSQLParam($categorytype).",".$db->safeSQLParam($listurl).",".$db->safeSQLParam($autocategory));
        $showindex = $db->mGet("iptv_category", "count(*)", "where type=".$db->safeSQLParam($categorytype)) - 1;

        if ($autocategory == "on"){
            $autocategory = $category;
            // 判断是否存在#genre#，如果存在则进行分类处理
            if (strpos($srclist, "#genre#") !== false) {
                $data = convertDataToArray($srclist);
                $genreNames = array_keys($data);
                $numCount = $numCount + 1;
                foreach ($genreNames as $genreItem) {
                    $genreName = trim($genreItem);
                    if (!empty($genreName)) {
                        $genreList = trim($data["$genreName"]);

                        // 拼接分类名
                        $categoryName = preg_replace('/\s+/', '',  $genreName."(".$category.")");

                        // 创建新分类
                        $db->mInt("iptv_category", "id,name,psw,type,autocategory", "$numCount,".$db->safeSQLParam($categoryName).",".$db->safeSQLParam($cpass).",".$db->safeSQLParam($categorytype).",".$db->safeSQLParam($autocategory));

                        // 添加频道列表
                        $addlist = add_channel_list($categoryName, $genreList);
                    
                        if ($addlist !== -1) {
                            echo "<script>showindex=$showindex;lightyear.notify('增加列表$categoryName 成功！', 'success', 3000);</script>";
                        } else {
                            echo "<script>showindex=$showindex;lightyear.notify('增加列表$categoryName 失败！', 'danger', 3000);</script>";
                            $db->mDel("iptv_category", "where name=".$db->safeSQLParam($categoryName));
                        }
                        $numCount++;
                    }
                }
            }else {
                echo "<script>showindex=$showindex;lightyear.notify('失败！列表$category 并非DIYP格式，请勿启用DIYP格式自动分类！', 'danger', 3000);</script>";
                $db->mDel("iptv_category", "where name=".$db->safeSQLParam($category));
            }
        } else {
            // 添加频道列表
            $addlist = add_channel_list($category, $srclist);

            if ($addlist !== -1) {
                echo "<script>showindex=$showindex;lightyear.notify('增加列表$category 成功！', 'success', 3000);</script>";
            } else {
                echo "<script>showindex=$showindex;lightyear.notify('增加列表$category 失败！', 'danger', 3000);</script>";
                $db->mDel("iptv_category", "where name=".$db->safeSQLParam($category));
            }
        }

        sort_id();
    }
}

// 更新外部列表
if (isset($_POST['updatelist'])) {
    $category = $_POST['thirdlist'];
    $listinfo = $db->mGetRow("iptv_category", "url, autocategory", "where name=" . $db->safeSQLParam($category));
    $listurl = $listinfo['url'];
    $listautocategory = $listinfo['autocategory'];

    // 统一弹窗输出函数
    function jsAlert($title, $msg, $type = "green") {
        echo "<script>$.alert({title: '{$title}',content: '{$msg}',type: '{$type}',buttons: {confirm: {text: '好',btnClass: 'btn-primary',action: function(){location.replace(location.href);}}}});</script>";
    }

    // 获取远程列表，带超时
    function getRemoteList($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    if ($category == "") {
        echo "<script>lightyear.notify('列表名称不能为空！', 'danger', 3000);</script>";
    } else {
        $srclist = getRemoteList($listurl);
        $srclist = filterEmoji($srclist);

        if ($listautocategory == "on") {
            if (strpos($srclist, "#genre#") !== false) {
                $data = convertDataToArray($srclist);
                $genreNames = array_keys($data);

                foreach ($genreNames as $genreItem) {
                    $genreName = trim($genreItem);
                    if (!empty($genreName)) {
                        $genreList = trim($data[$genreName]);
                        $categoryName = preg_replace('/\s+/', '', $genreName . "(" . $category . ")");

                        // 判断是否存在该分类
                        $exists = $db->mGet("iptv_category", "count(*)", "where name=" . $db->safeSQLParam($categoryName));

                        if ($exists > 0) {
                            $addlist = add_channel_list($categoryName, $genreList);
                            if ($addlist !== -1) {
                                jsAlert("成功", "更新列表 {$categoryName} 成功！");
                            } else {
                                jsAlert("失败", "更新列表 {$categoryName} 失败！", "red");
                            }
                        } else {
                            // 计算新 ID
                            $maxid = $db->mGet("iptv_category", "max(id)");
                            $numCount = $maxid + 1;

                            $db->mInt("iptv_category", "id,name,psw,type,autocategory", 
                                "$numCount," . $db->safeSQLParam($categoryName) . "," . 
                                $db->safeSQLParam($cpass) . "," . 
                                $db->safeSQLParam($categorytype) . "," . 
                                $db->safeSQLParam($category));

                            $addlist = add_channel_list($categoryName, $genreList);
                            if ($addlist !== -1) {
                                jsAlert("成功", "新增并更新列表 {$categoryName} 成功！");
                            } else {
                                jsAlert("失败", "新增并更新列表 {$categoryName} 失败！", "red");
                            }
                        }
                    }
                }
            } else {
                // 不含 #genre#，取消自动分类
                $db->mSet("iptv_category", "autocategory=NULL", "where name=" . $db->safeSQLParam($category));
                $addlist = add_channel_list($category, $srclist);
                if ($addlist !== -1) {
                    jsAlert("成功", "更新列表 {$category} 成功！");
                } else {
                    jsAlert("失败", "更新列表 {$category} 失败！", "red");
                }
            }
        } else {
            // 普通更新
            $addlist = add_channel_list($category, $srclist);
            if ($addlist !== -1) {
                jsAlert("成功", "更新列表 {$category} 成功！");
            } else {
                jsAlert("失败", "更新列表 {$category} 失败！", "red");
            }
        }

        // 重新排序
        sort_id();
    }
}

// 删除外部列表
if (isset($_POST['dellist'])) {
    $category = $_POST['thirdlist'];
    if ($category == "") {
        echo "<script>lightyear.notify('列表名称不能为空！', 'danger', 3000);</script>";
    } else {
        $listautocategory = $db->mGet("iptv_category", "autocategory", "where name=".$db->safeSQLParam($category));
		if ($listautocategory == "on") {
            $result = $db->mGet("iptv_category", "name", "where autocategory=".$db->safeSQLParam($category));
            while ($listname = $result) {
                if ($categoryid = $db->mGet("iptv_category", "id", "where name=".$db->safeSQLParam($listname))) {
                    $db->mSet("iptv_category", "id=id-1", "where id>$categoryid");
                } 
                $db->mDel("iptv_category", "where name=".$db->safeSQLParam($listname));
                $db->mDel("iptv_channels", "where category=".$db->safeSQLParam($listname));
                echo "<script>showindex=$showindex-1;lightyear.notify('$listname 删除成功！', 'success', 3000);</script>";
            
                // 获取下一条name值
                $result = $db->mGet("iptv_category", "name", "where autocategory=".$db->safeSQLParam($category));
            }
            if ($categoryid = $db->mGet("iptv_category", "id", "where name=".$db->safeSQLParam($category))) {
                $db->mSet("iptv_category", "id=id-1", "where id>$categoryid");
            } 
			$db->mDel("iptv_category", "where name=".$db->safeSQLParam($category));
            echo "<script>showindex=$showindex-1;lightyear.notify('$category 删除成功！', 'success', 3000);</script>";
		} else {
            if ($categoryid = $db->mGet("iptv_category", "id", "where name=".$db->safeSQLParam($category))) {
                $db->mSet("iptv_category", "id=id-1", "where id>$categoryid");
            } 
			$db->mDel("iptv_category", "where name=".$db->safeSQLParam($category));
			$db->mDel("iptv_channels", "where category=".$db->safeSQLParam($category));
            echo "<script>showindex=$showindex-1;lightyear.notify('$category 删除成功！', 'success', 3000);</script>";
		}
        sort_id();
    }
}

// 转换列表格式
function convert_list_format($srclist) {
    // 检查最后一行是否有换行符，如果没有则添加一个换行符
    if (substr($srclist, -1) !== "\n") {
        $srclist .= "\n";
    }

    $converted_list = "";
	$pattern = '/#EXTINF:-?\d+.*?,(.*?)\n(.*?)\n/';
    preg_match_all($pattern, $srclist, $matches, PREG_SET_ORDER);
    if (!empty($matches)) {
        foreach ($matches as $match) {
            $channelname = $match[1];
            $channelname = preg_replace('/\s.*$/', '', $channelname);
            $channelurl = $match[2];
            $converted_list .= $channelname . "," . $channelurl . "\n";
        }
    } else {
        $pattern = '/(.*?),(.*)\n/';
        preg_match_all($pattern, $srclist, $matches, PREG_SET_ORDER);
        if (!empty($matches)) {
            foreach ($matches as $match) {
                $channelname = $match[1];
                $channelname = preg_replace('/\s.*$/', '', $channelname);
                $channelurl = $match[2];
                $converted_list .= $channelname . "," . $channelurl . "\n";
            }
        } else {
            $converted_list = $srclist;
        }
    }
    return $converted_list;
}

//DIYP格式转换为数组
function convertDataToArray($data) {
    $lines = explode("\n", $data);
    $result = [];
    $currentGenre = '';
    
    foreach ($lines as $line) {
        $line = trim($line);
        
        if (empty($line)) {
            continue;
        }
        
        if (strpos($line, '#genre#') !== false) {
            $currentGenre = str_replace(',#genre#', '', $line);
            $result[$currentGenre] = '';
        } else {
            $result[$currentGenre] .= $line . "\n";
        }
    }
    
    foreach ($result as &$genreData) {
        $genreData = trim($genreData);
    }

    return $result;
}

// 过滤掉emoji表情
function filterEmoji($str)
{
    $str = preg_replace_callback(
	        '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },
            $str);

     return $str;
 }

// 删除分类
if (isset($_POST['submit_deltype']) && isset($_POST['category'])) {
    $category = $_POST['category'];
    $showindex = $_POST['showindex'];
    if ($category == "") {
        echo "<script>lightyear.notify('类别名称不能为空！', 'danger', 3000);</script>";
    } else {
        if ($categoryid = $db->mGet("iptv_category", "id", "where name=".$db->safeSQLParam($category))) {
            $db->mSet("iptv_category", "id=id-1", "where id>$categoryid");
        } 
        $db->mDel("iptv_category", "where name=".$db->safeSQLParam($category));
        $db->mDel("iptv_channels", "where category=".$db->safeSQLParam($category));
        sort_id();
        echo "<script>showindex=$showindex-1;lightyear.notify('$category 删除成功！', 'success', 3000);</script>";
    } 
} 
// 修改分类
if (isset($_POST['submit_modifytype']) && isset($_POST['category'])) {
    $category = $_POST['category'];
    $cpass = $_POST['cpass'];
    $showindex = $_POST['showindex'];
    $category0 = $_POST['typename0'];
    if ($category == "") {
        echo "<script>lightyear.notify('类别名称不能为空！', 'danger', 3000);</script>";
    } else {
        $db->mSet("iptv_category", "name=".$db->safeSQLParam($category).",psw=".$db->safeSQLParam($cpass), "where name=".$db->safeSQLParam($category0));
        $db->mSet("iptv_channels", "category=".$db->safeSQLParam($category), "where category=".$db->safeSQLParam($category0));
        echo "<script>showindex=$showindex;lightyear.notify('$category 修改成功！', 'success', 3000);</script>";
        $cname = $category;
    } 
} 
// 上移分类
if (isset($_POST['submit_moveup']) && isset($_POST['category'])) {
    $category = $_POST['category'];
    $showindex = $_POST['showindex'];
    if ($id = $db->mGet("iptv_category", "id", "where name=".$db->safeSQLParam($category))) {
        $preid = $id-1;
        if ($preid >= $minid) {
            $db->mSet("iptv_category", "id=id+1", "where id=$preid");
            $db->mSet("iptv_category", "id=id-1", "where name=".$db->safeSQLParam($category));
            echo "<script>showindex=$showindex-1;</script>";
        } else {
            echo "<script>showindex=$showindex-1;lightyear.notify('已经上移到最顶了！', 'danger', 3000);</script>";
        } 
    } 
} 
// 下移分类
if (isset($_POST['submit_movedown']) && isset($_POST['category'])) {
    $category = $_POST['category'];
    $showindex = $_POST['showindex'];
    if ($id = $db->mGet("iptv_category", "id", "where name=".$db->safeSQLParam($category))) {
        $nextid = $id + 1;
        if ($nextid <= $maxid) {
            $db->mSet("iptv_category", "id=id-1", "where id=$nextid");
            $db->mSet("iptv_category", "id=id+1", "where name=".$db->safeSQLParam($category));
            echo "<script>showindex=$showindex+1;</script>";
        } else {
            echo "<script>showindex=$showindex;lightyear.notify('已经下移到最底了！', 'danger', 3000);</script>";
        } 
    } 
} 
// 置顶分类
if (isset($_POST['submit_movetop']) && isset($_POST['category'])) {
    $category = $_POST['category'];
    if ($id = $db->mGet("iptv_category", "Min(id)", "where type=".$db->safeSQLParam($categorytype))) {
        $id = $id-1;
        $db->mSet("iptv_category", "id=$id", "where name=".$db->safeSQLParam($category));
        sort_id();
        echo "<script>showindex=0;</script>";
    } 
} 
// 列表设置
if (isset($_POST['submit']) && isset($_POST['ver'])) {
    $updateinterval = $_POST['updateinterval'];
    if (isset($_POST['autoupdate'])) {
		$db->mSet("iptv_config", "value='1'", "where name='autoupdate'");
		$db->mSet("iptv_config", "value=".$db->safeSQLParam($updateinterval), "where name='updateinterval'");
    } else {
        $ver = $_POST['ver'];
		$db->mSet("iptv_config", "value='0'", "where name='autoupdate'");
		$db->mSet("iptv_config", "value=".$db->safeSQLParam($ver), "where name='dataver'");
    } 
    echo "<script>lightyear.notify('保存成功！', 'success', 3000);</script>";
} 
// 分类开关
if (isset($_POST['checkpdname'])) {
    $db->mSet("iptv_category", "enable=0");
    foreach ($_POST['enable'] as $categoryenable) {
        $db->mSet("iptv_category", "enable=1", "where name=".$db->safeSQLParam($categoryenable));
    } 
} 
// 获取列表设置
$ver = $db->mGet("iptv_config", "value", "where name='dataver'");
$versionname = $db->mGet("iptv_config", "value", "where name='appver'");
$autoupdate = $db->mGet("iptv_config", "value", "where name='autoupdate'");
$updateinterval = $db->mGet("iptv_config", "value", "where name='updateinterval'");

if ($autoupdate == 1) {
    $checktext = "checked='true'";
} else {
    $checktext = '';
} 

?>