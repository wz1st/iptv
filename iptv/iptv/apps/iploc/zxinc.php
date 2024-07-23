<?php
header("Content-type: text/json; charset=utf-8");
header("Cache-Control:no-cache,must-revalidate");
header("Pragma: no-cache");

$ip = $_GET['ip'];
$url = "http://ip.zxinc.org/api.php?type=json&ip=$ip";
retry:
$jsonobj = file_get_contents($url);
if (empty($jsonobj)) {
    $jsonobj = (Object)null;
    goto retry;
} 
$jsonobj = trim($jsonobj,chr(239).chr(187).chr(191));
$ipobj = json_decode($jsonobj);
$region = $ipobj->data->country;
$isp = $ipobj->data->local;
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
