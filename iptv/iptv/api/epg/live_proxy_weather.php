<?php
include "curl.class.php";
include "caches.class.php";
javascript:;
include "update.class.php";
include_once "../../config.php";

define('SELF', pathinfo(__file__, PATHINFO_BASENAME));
define('FCPATH', str_replace("\\", "/", str_replace(SELF, '', __file__)));
date_default_timezone_set('PRC');
header("Content-Type:application/json;chartset=uft-8");
$ip = ip();
if(empty($ip))exit(json_encode(["code"=>500,"msg"=>"没有找到位置信息！","name"=>$name,"date"=>null,"data"=>null],JSON_UNESCAPED_UNICODE));

echo out_weather($ip);
exit;

//输出天气json
function out_weather($ip){
	$cip = $ip;//获取客户ip
	$tt=cache("time_out_chk","cache_time_out");
	//获取当前时间（后天）的00:00时间戳
	if (time()>=$tt) {
		Cache::$cache_path="./cache/";
		//设置缓存路径
		//删除除当前目录缓存文件
		Cache::dels();
		//重新写入当天时间缓存文件
		cache("time_out_chk","cache_time_out");
	}
	$wjson=cache($ip,"get_weather_data",[$ip]);
	$wjson = getJsonByCache($wjson);
	return $wjson;

}

function getJsonByCache($ejson) {
	//从缓存获取最新json位置
	$iarr = json_decode($ejson,true);
	$cache_ret=array("code"=>200,"msg"=>"请求成功!");
	$cache_ret["content"] = $iarr;
	return json_encode($cache_ret,JSON_UNESCAPED_UNICODE);
}

//缓存weaher天气数据
function cache($key,$f_name,$ff=[]) {
	Cache::$cache_path="./cache/";
	//设置缓存路径
	$val=Cache::gets($key);
	if (!$val) {
		$data=call_user_func_array($f_name,$ff);
		Cache::put($key,$data);
		return $data;
	} else {
		return $val;
	}
}
function cache_time_out() {
	date_default_timezone_set("Asia/Shanghai");
	$tt=strtotime(date("Y-m-d 00:00:00",time()))+86400;
	return $tt;
}
function get_weather_data($ip){
	echo $ip;
	$weaapi_id=get_config('weaapi_id');
	$weaapi_key=get_config('weaapi_key');
	unset($row);
	mysqli_free_result($result);
	$url = "http://www.tianqiapi.com/api?version=v1&appid=$weaapi_id&appsecret=$weaapi_key&ip=".$ip;
	$str=curl::c()->set_ssl()->get($url);
	$re=json_decode($str,true);
	$re=json_encode($re,JSON_UNESCAPED_UNICODE);
	return $re;
}

function ip() {
    //strcasecmp 比较两个字符，不区分大小写。返回0，>0，<0。
    if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } else if (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } else if (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $res =  preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
    //echo $res;
    //dump(phpinfo());//所有PHP配置信息
    return $res;
}

?>