<?php
header("Content-type: text/json; charset=utf-8");
header("Cache-Control:no-cache,must-revalidate");
header("Pragma: no-cache");
require_once "config.php";
$GetIP = new GetIP();
$db = Config::GetIntance();

if (@$_GET['ip']=='myip'){$ip=$GetIP->getuserip();}else{$ip=@$_GET['ip'];}
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' || 
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ||
            isset($_SERVER['HTTP_FRONT_END_HTTPS']) && $_SERVER['HTTP_FRONT_END_HTTPS'] === 'on' ? 'https://' : 'http://';
$myurl=dirname($protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$ipchk = $db->mGet("iptv_config", "value", "where name='ipchk'");
if($ipchk=='1'){
	echo file_get_contents("$myurl/apps/iploc/qqzeng.php?ip=$ip");
}else if($ipchk=='2'){
	echo file_get_contents("$myurl/apps/iploc/ipcn.php?ip=$ip");
}else if($ipchk=='3'){
	echo file_get_contents("$myurl/apps/iploc/taobao.php?ip=$ip");
}else if($ipchk=='4'){
	echo file_get_contents("$myurl/apps/iploc/fusion.php?ip=$ip");
}else if($ipchk=='5'){
	echo file_get_contents("$myurl/apps/iploc/pconline.php?ip=$ip");
}else if($ipchk=='6'){
	echo file_get_contents("$myurl/apps/iploc/zxinc.php?ip=$ip");
}

?>
