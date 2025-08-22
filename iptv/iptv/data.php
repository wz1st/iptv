<?php
require_once"aes.php";
require_once "config.php";
$db = Config::GetIntance();
$channelNumber = 1;

function echoJSON($category, $alisname, $psw) {
    global $db, $channelNumber;
    if ($alisname == '我的收藏') {
        $channelname = $alisname;
    } else {
        $channelname = $db->mGet("iptv_channels", "name", "where category=".$db->safeSQLParam($category));
    } 
    if (!empty($channelname)) {
        $result = $db->mQuery("SELECT name,url FROM iptv_channels where category=".$db->safeSQLParam($category)." order by id");
        $nameArray = array();
        while ($row = mysqli_fetch_array($result)) {
            if (!in_array($row['name'], $nameArray)) {
                $nameArray[] = $row['name'];
            } 
            $sourceArray[$row['name']][] = $row['url'];
        } 
        $objCategory = (Object)null;
        $objChannel = (Object)null;
        $channelArray = array();
        for($i = 0;
            $i < count($nameArray);
            $i++) {
            $objChannel = (Object)null;
            $objChannel->num = $channelNumber;
            $objChannel->name = $nameArray[$i];
            $objChannel->source = $sourceArray[$nameArray[$i]];
            $channelArray[] = $objChannel;
            $channelNumber++;
        } 
        $objCategory->name = $alisname;
        $objCategory->psw = $psw;
        $objCategory->data = $channelArray;
        unset($row,$nameArray, $sourceArray, $objChannel);
        mysqli_free_result($result);
        return $objCategory;
    } 
} 

if (isset($_POST['data'])) {
    $obj = json_decode($_POST['data']);
    $region = $obj->region;
    $mac = $obj->mac;
    $androidid = $obj->androidid;
    $model = $obj->model;
    $nettype = $obj->nettype;
    $appname = $obj->appname;
    $randkey = $obj->rand;
    if (strpos($region, '中国') !== false) {
        $region = "北京";
    } 
    if (strpos($nettype, '电信') !== false) {
        $nettype = "chinanet";
    } else if (strpos($nettype, '联通') !== false) {
        $nettype = "unicom";
    } else if (strpos($nettype, '移动') !== false) {
        $nettype = "cmcc";
    } else {
        $nettype = "";
    } 
    // 查找当前用户对应的套餐
    $result = $db->mQuery("SELECT meal from iptv_users where deviceid=".$db->safeSQLParam($androidid));
    if (mysqli_num_rows($result)) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if (empty($row["meal"])) {
            $mid = 1000;
            mysqli_free_result($result);
        } else {
            $mid = $row["meal"];
            mysqli_free_result($result);
        } 
    } else {
        $mid = 1000;
        mysqli_free_result($result);
    } 
    // 检测套餐是否存在，收视内容是否为空
    $result = $db->mQuery("select content from iptv_meals where status=1 and id=$mid");
    if (mysqli_num_rows($result)) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if (empty($row["content"])) {
            $m_text = false;
            mysqli_free_result($result);
        } else {
            $m_text = $row["content"];
            mysqli_free_result($result);
        } 
    } else {
        $m_text = false;
        mysqli_free_result($result);
    } 
    // 增加我的收藏
    $contents[] = echoJSON('', "我的收藏", ''); 
    // 默认套餐不输出运营商,即默认套餐的ID不等于1000输出运营商和各省的输出
    if ($mid != 1000) {
        if (!empty($nettype)) {
            // 添加运营商频道数据,自动分配联通 电信 移动 对应的节目表
            $result = $db->mQuery("SELECT name,id,psw FROM iptv_category where enable=1 and (autocategory IS NULL OR autocategory!='on') and type=".$db->safeSQLParam($nettype)." order by id");
            while ($row = mysqli_fetch_array($result)) {
                $pdname = $row['name'];
                $psw = $row['psw'];
                $contents[] = echoJSON($pdname, $pdname, $psw);
            } 
            unset($row);
            mysqli_free_result($result);
        } 
        // 添加国内每个省内频道数据
        if (isset($region) && $region != '') {
            $result = $db->mQuery("SELECT name,id,psw FROM iptv_category where enable=1 and (autocategory IS NULL OR autocategory!='on') and type='province' and name like ".$db->safeSQLParam($region.'%')." order by id");
            while ($row = mysqli_fetch_array($result)) {
                $pdname = $row['name'];
                $psw = $row['psw'];
                $contents[] = echoJSON($pdname, '省内频道', $psw);
            } 
            unset($row);
            mysqli_free_result($result);
        } 
    } 
    // 授权的套餐的数据
    if ($m_text) {
        $m_str = explode("_", $m_text);
        foreach ($m_str as $id => $meal_content) {
            $result = $db->mQuery("SELECT name,id,psw FROM iptv_category where enable=1 and (autocategory IS NULL OR autocategory!='on') and name=".$db->safeSQLParam($meal_content)." ORDER BY id asc");
            if (!mysqli_num_rows($result)) {
                mysqli_free_result($result);
            } else {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $pdname = $row['name'];
                $psw = $row['psw'];
                $contents[] = echoJSON($pdname, $pdname, $psw);
                unset($row);
                mysqli_free_result($result);
            } 
        } 
        unset($m_str, $m_text);
    } else {
        unset($m_str, $m_text);
        $result = $db->mQuery("SELECT name,id,psw FROM iptv_category where enable=1 and (autocategory IS NULL OR autocategory!='on') and type='default' order by id");
        while ($row = mysqli_fetch_array($result)) {
            $pdname = $row['name'];
            $psw = $row['psw'];
            $contents[] = echoJSON($pdname, $pdname, $psw);
        } 
        unset($row);
        mysqli_free_result($result);
    } 
    $str = json_encode($contents, JSON_UNESCAPED_UNICODE);
    $str = preg_replace('#null,#', '', $str);
    $str = stripslashes($str);
    $str = base64_encode(gzcompress($str));
    $key = md5($key . $randkey);
    $key = substr($key, 7, 16);
    $aes = new Aes($key);
    $encrypted = $aes->encrypt($str);
    $encrypted = str_replace("f", "&", $encrypted);
    $encrypted = str_replace("b", "f", $encrypted);
    $encrypted = str_replace("&", "b", $encrypted);
    $encrypted = str_replace("t", "#", $encrypted);
    $encrypted = str_replace("y", "t", $encrypted);
    $encrypted = str_replace("#", "y", $encrypted);
    $coded = substr($encrypted, 44, 128);
    $coded = strrev($coded);
    $str = $coded . $encrypted;
    echo $str;
} else {
    exit();
} 

?>