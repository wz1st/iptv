<?php
header('Content-Type: text/json;charset=UTF-8');
$dir=dirname(__FILE__);
$dir=$dir.'/images';
$files = glob("images/*.png");
$pngs = array();
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' || 
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ||
            isset($_SERVER['HTTP_FRONT_END_HTTPS']) && $_SERVER['HTTP_FRONT_END_HTTPS'] === 'on' ? 'https://' : 'http://';
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url= dirname($url).'/';

foreach ($files as $file) {
	$pngs[]=$url.$file;
}

unset($files);
$rkey=array_rand($pngs);
echo $pngs[$rkey];
?>

