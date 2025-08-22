<?php
include_once "../config.php";
$db = Config::GetIntance();

$value = $db->mGet("iptv_config", "value", "where name='epg_api_chk'");
$tipepgerror_1000 = $db->mGet("iptv_config", "value", "where name='tipepgerror_1000'");
$tipepgerror_1001 = $db->mGet("iptv_config", "value", "where name='tipepgerror_1001'");
$tipepgerror_1002 = $db->mGet("iptv_config", "value", "where name='tipepgerror_1002'");
$tipepgerror_1003 = $db->mGet("iptv_config", "value", "where name='tipepgerror_1003'");
$tipepgerror_1004 = $db->mGet("iptv_config", "value", "where name='tipepgerror_1004'");
$tipepgerror_1005 = $db->mGet("iptv_config", "value", "where name='tipepgerror_1005'");
if ($value != 0) {
    function msg($code, $msg) {
        date_default_timezone_set("Asia/Shanghai");
        header('content-type:application/json;charset=utf-8');
        $arr = [];
        $datas = [];
        $datas["name"] = $msg;
        $datas["starttime"] = date("H:i", time());
        $arr["code"] = $code;
        $arr["msg"] = $msg;
        $arr["name"] = "Access deniend";
        $arr["tvid"] = "1";
        $arr["date"] = date("Y-m-d", time());
        $arr["data"] = [$datas];
        $str = json_encode($arr, JSON_UNESCAPED_UNICODE);
        unset($arr, $datas);
        echo $str;
        exit;
    } 

    $utoken = !empty($_SERVER["HTTP_USER_TOKEN"])?$_SERVER["HTTP_USER_TOKEN"]:msg(200, $tipepgerror_1000);
    $uid = !empty($_SERVER["HTTP_USER_ID"])?$_SERVER["HTTP_USER_ID"]:msg(200, $tipepgerror_1001);
    $uip = !empty($_SERVER["HTTP_USER_IP"])?$_SERVER["HTTP_USER_IP"]:msg(200, $tipepgerror_1002);

    $randkey = $db->mGet("iptv_config", "value", "where name='randkey'");
    if ($utoken != $randkey) {
        msg(200, $tipepgerror_1003);
        exit();
    } 

    $ip = $db->mGet("iptv_users", "ip", "where where name='$uid'");
    if (!empty($ip)) {
        if ($uip != $ip) {
            msg(200, $tipepgerror_1004);
            exit();
        } 
    } else {
        msg(200, $tipepgerror_1005);
        exit();
    } 
} 

?>