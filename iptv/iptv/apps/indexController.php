<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

?>

<?php 
// 用户总数统计
if ($row = $db->mGetRow("iptv_users", "count(*)")) {
    $userCount = $row[0];
    if ($recCounts != 0) {
        $pageCount = ceil($row[0] / $recCounts);
    } else {
        $pageCount = 1;
    }
} else {
    $userCount = 0;
    $pageCount = 1;
} 
unset($row);
// 今日上线用户总数统计
$todayTime = strtotime(date("Y-m-d"), time());
if ($row = $db->mGetRow("iptv_users", "count(*)", "where lasttime>$todayTime")) {
    $todayuserCount = $row[0];
} else {
    $todayuserCount = 0;
} 
unset($row);
// 今日授权用户总数统计
if ($row = $db->mGetRow("iptv_users", "count(*)", "where status>0 and authortime>$todayTime")) {
    $todayauthoruserCount = $row[0];
} else {
    $todayauthoruserCount = 0;
} 
unset($row);
// 异常用户总数统计
if ($row = $db->mGetRow("iptv_users", "count(*)", "where vpn>0")) {
    $exceptionuserCount = $row[0];
} else {
    $exceptionuserCount = 0;
} 
unset($row);
// 分类总数统计
if ($row = $db->mGetRow("iptv_category", "count(*)", " where autocategory IS NULL OR autocategory!='on'")) {
    $categoryCount = $row[0];
} else {
    $categoryCount = 0;
} 
unset($row);
// 频道总数统计
if ($row = $db->mGetRow("iptv_channels", "count(*)")) {
    $channelCount = $row[0];
} else {
    $channelCount = 0;
} 
unset($row);
// EPG总数统计
if ($row = $db->mGetRow("iptv_epg", "count(*)")) {
    $epgCount = $row[0];
} else {
    $epgCount = 0;
} 
unset($row);
// VIP用户总数统计
if ($row = $db->mGetRow("iptv_meals", "count(*)")) {
    $mealsCount = $row[0];
} else {
    $mealsCount = 0;
} 
unset($row);

?>