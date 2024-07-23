<?php
header("Content-type: text/json; charset=utf-8");
header("Cache-Control:no-cache,must-revalidate");
header("Pragma: no-cache");

$ip = $_GET['ip'];
$url = "http://whois.pconline.com.cn/ip.jsp?ip=$ip";
retry:
$ipobj = iconv("gbk", "utf-8",file_get_contents($url));
if (empty($ipobj)) {
    $ipobj = (Object)null;
    goto retry;
} 
$str = preg_replace('#\r#', '', $ipobj);
$str = preg_replace('#\n#', '', $str);
$str = explode(" ", $str);
$region = $str[0];
$isp = $str[1];
$obj = (Object)null;
$obj->region = $region;
if (!empty($region)) {
	$obj->city = '，' ;
}
if (!empty($isp)) {
	$obj->isp = $isp;
} else {
	$obj->city = '' ;
	$obj->isp = '' ;
}

$json['data'] = $obj;
echo json_encode($json, JSON_UNESCAPED_UNICODE);
?>