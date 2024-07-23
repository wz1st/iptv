<?php
header("Content-type: text/json; charset=utf-8");
header("Cache-Control:no-cache,must-revalidate");
header("Pragma: no-cache");

$ip = $_GET['ip'];
$url = "https://www.ip.cn/index.php?ip=$ip";
retry:
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_TIMEOUT, 2);
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; Android 8.0.0; Pixel 2 XL Build/OPD1.170816.004) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Mobile Safari/537.36');
$curljson = curl_exec($curl);
curl_close($curl);
if (empty($curljson)) {
    $curljson = (Object)null;
    goto retry;
} 
preg_match('/所在地理位置：<code>(.*?)<\/code>/i',$curljson,$ipobj);
$str = explode(" ", $ipobj[1]);
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