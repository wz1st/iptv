<?php
chks();
function chks(){
	$utoken=!empty($_SERVER["HTTP_USER_TOKEN"])?$_SERVER["HTTP_USER_TOKEN"]:msg(200,"1000_EPG接口验证失败,请与管理员联系!如有疑问请加QQ：87351183");
	$uid=!empty($_SERVER["HTTP_USER_ID"])?$_SERVER["HTTP_USER_ID"]:msg(200,"1001_EPG接口验证失败,请与管理员联系!如有疑问请加QQ：87351183");
	$uip=!empty($_SERVER["HTTP_USER_IP"])?$_SERVER["HTTP_USER_IP"]:msg(200,"1002_EPG接口验证失败,请与管理员联系!如有疑问请加QQ：87351183");
	$u=explode("|",str_de($utoken));
	if(count($u)<4){
		unset($utoken,$uid,$uip,$u);
		msg(200,"1003_EPG接口验证失败,请与管理员联系!如有疑问请加QQ：87351183");
	}
	if(hex_de($uid) != $u[1]){
		unset($utoken,$uid,$uip,$u);
		msg(200,"1004_EPG接口验证失败,请与管理员联系!如有疑问请加QQ：87351183");
	}elseif(hex_de($uip) != $u[0]){
		unset($utoken,$uid,$uip,$u);
		msg(200,"1005_EPG接口验证失败,请与管理员联系!如有疑问请加QQ：87351183");
	}
}
function hex_de($str){
	$str=strrev($str);
	return hex2bin($str);
}
function str_de($str){
   $kid=$str[0];  
   $str=substr($str,1,strlen($str)-1); 
   $data=aes_decode($str,$kid);
   $data=@gzuncompress($data);
   if (empty($data) ) {
       return false;
   }
   return $data;
}
function aes_decode($str,$kvid){
    $kv=key_iv($kvid);
	$key=hex2bin($kv["key"]);
	$iv=hex2bin($kv["iv"]);
	$method="AES-128-CBC";  //加密模式
	$options=OPENSSL_RAW_DATA;  //是以下标记的按位或： OPENSSL_RAW_DATA 、 OPENSSL_ZERO_PADDING
	unset($kv);
	$data=str_rep_de($str);
	$data=openssl_decrypt($data,$method,$key,$options,$iv);
	if (empty($data)) {
	    return false;
	}
	return $data;
} 
function str_rep_de($str){
   $data = str_replace(array('-','_'),array('+','/'),$str);
   $mod4 = strlen($data) % 4;
   if ($mod4) {
       $data .= substr('====', $mod4);
   }
   return base64_decode($data);
} 
function msg($code,$msg){
		date_default_timezone_set("Asia/Shanghai");
		header('content-type:application/json;charset=utf-8');
		$arr=[];
		$datas=[];
		$datas["name"]="您现在是盗用EPG接口如有疑问请加QQ：87351183";
		$datas["starttime"]=date("H:i",time());
		$arr["code"]=$code;
		$arr["msg"]=$msg;
		$arr["name"]="CCTV1";
		$arr["tvid"]="34";
		$arr["date"]=date("Y-m-d",time());
		$arr["data"]=[$datas];
		$str=json_encode($arr,JSON_UNESCAPED_UNICODE);
		unset($arr,$datas);
		echo $str;
		exit;
	} 
function key_iv($id=0){
    $arr=[
		["key"=>"2f88aa02747f4bfb9d86975a37fb9d04","iv"=>"81fb407a0294d0d2fd179c8bf2b42f58"],
		["key"=>"8bde6da3e3802b38df5c0e1953a2665d","iv"=>"0630ad27a0740b5ef5f11993d15a3497"],
		["key"=>"1d9fbfcdc960799921460f1c5ac4d2a7","iv"=>"f924018c7248de7c350582a1829a9027"],
		["key"=>"5b3930976bb3ee080d25b9ac97e26484","iv"=>"f0bb28b5352916d92c9a17f6f50e20e5"],
		["key"=>"78a654682cf38568feb1eea231286a28","iv"=>"011134ee06e6ec2c12b9e4e1a8012a24"],
		["key"=>"89fe05137dddc94661308cf9175f6c45","iv"=>"0040c229b580efb7839ebf7d41099c19"],
		["key"=>"79d20659ee1930b8c19d5882b2c6902a","iv"=>"92315f10b3c46d10754ef3e9b76719d0"],
		["key"=>"683c452d8bc4fc5ca1849a18e12d5562","iv"=>"3f6a0d1d00dc56bf09775c0a662d108e"],
		["key"=>"010a936e4661f15eb32f96a38cc6fb07","iv"=>"11e86a2c1135dd6de590efc99cc81eaa"],
		["key"=>"286f269fb28af206986b520fb2a54629","iv"=>"7400a6514c47c9ea0304255c05ad5c81"],
		
	];
	$id=($id>=0 && $id<=9)?$id:0;
	return $arr[$id];
} 
?>