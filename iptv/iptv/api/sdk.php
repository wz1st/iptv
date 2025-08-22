<?php
include "../inc/app_key_config.php";
function isMyPlayer(){
	if(isMyPlayer1()||isMyPlayer2()){
		return true;
	}else{
		return false;
	}
}

function isMyPlayer1(){
	$Agent = $_SERVER['HTTP_USER_AGENT'];
	if(strpos($Agent,'-')!==false){
		$t=explode("-", $Agent)[0];
		$sign=explode("-", $Agent)[1];
		$sig=APPS_SIG;
		$key=APPS_KEY;
		$d=time();
		if(abs($d-$t)>600){
			return false;
		}else{
			if($sign!=md5($key.$t."303543214".$sig)){
				return false;
			}else{
				return true;
			}
		}
	}else{
		return false;
	}	
}
function isMyPlayer2(){
	if(isset($_GET['token'])){
		$k=$_GET['token'];
		//读取token.txt首行内容
		$file=fopen("token.txt", "r");
		$token=fgets($file);
		fclose($file);

		if($k==$token){
			return true;
		}
	}
	if(isset($_GET['t'])&&isset($_GET['sign'])){
		$t=$_GET['t'];
		$sign=$_GET['sign'];
		$sig=APPS_SIG;
		$key=APPS_KEY;
		$d=time();
		if(abs($d-$t)>600){
			return false;
		}else{
			if($sign!=md5($key.$t."303543214".$sig)){
				return false;
			}else{
				return true;
			}
		}
	}else{
		return false;
	}
}
?>