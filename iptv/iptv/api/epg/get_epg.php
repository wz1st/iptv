<?php
include "curl.class.php";
include "caches.class.php";javascript:;
include "update.class.php";

define('SELF', pathinfo(__file__, PATHINFO_BASENAME));
define('FCPATH', str_replace("\\", "/", str_replace(SELF, '', __file__)));
date_default_timezone_set('PRC'); 
header("Content-Type:application/json;chartset=uft-8");
$url = "http://www.tvsou.com/epg/";
$file=curl::c()->set_ssl()->get($url);
$file =  preg_replace(array("/<script[\s\S]*?<\/script>/i","/<a .*?href='(.*?)'.*?>/is","/<tbody>/i","/<\/a>/i"), '', $file);
echo $file;
?>
