<?php
ini_set('memory_limit', '-1');
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
include "curl.class.php";
javascript:;
include "caches.class.php";
include "update.class.php";
//include "proxy_chk.php";
define('SELF', pathinfo(__file__, PATHINFO_BASENAME));
define('FCPATH', str_replace("\\", "/", str_replace(SELF, '', __file__)));
date_default_timezone_set('PRC');
include_once "../../config.php";


mysqli_query($GLOBALS['conn'],"SET NAMES 'UTF8'");
header("Content-Type:application/json;chartset=uft-8");
$id=!empty($_GET["id"])?$_GET["id"]:exit(json_encode(["code"=>500,"msg"=>"EPG频道参数不能为空!","name"=>$name,"date"=>null,"data"=>null],JSON_UNESCAPED_UNICODE));
if(!empty($_GET["simple"])){
	echo out_epg($id,!empty($_GET["simple"]));
}else{
	echo out_epg($id);

}

//输出EPG节目地址
function out_epg($id,$is_simple) {

	$id =  str_replace(' ', '', $id);
	//$tvdata = channel($id);
	$tvdata = channel_sql($id);
	$tvid = $tvdata['id'];
	$epgid =  $tvdata['name'];
	if (!is_numeric($tvid)) {
		return $tvid;
	}
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
	//echo $tvid,$epgid,$id;
	$ejson=cache($tvid,"get_epg_data",[$tvid,$epgid,$id]);
	if($is_simple){
		$ejson = getJsonByCacheAndPos($ejson);
	}else{
		$ejson = getJsonByCache($ejson);
	}
	
	return $ejson;
}
function getJsonByCache($ejson) {
	//从缓存获取最新json位置
	$iarr = json_decode($ejson,true);
	$i=0;
	$cache_ret=array("code"=>200,"msg"=>"请求成功!");
	$cache_ret["pos"] = getPos($data["data"][] = array($iarr['data']),$iarr['which']);
	$cache_ret["data"] = $iarr['data'];
	return json_encode($cache_ret,JSON_UNESCAPED_UNICODE);
}
function getJsonByCacheAndPos($ejson) {
	//从缓存获取最新json位置
	$iarr = json_decode($ejson,true);
	$i=0;
	$cache_ret=array("code"=>200,"msg"=>"请求成功!");
	$pos = getPos($data["data"][] = array($iarr['data']),$iarr['which']);
	if($pos>=0){
		$cache_ret['data'] = $iarr['data'][$pos];
	}
	return json_encode($cache_ret,JSON_UNESCAPED_UNICODE);
}
//获取当前播放位置
function getPos($json,$which_api) {
	$curpos_sure=false;
	$cur=date("H:i");
	$pos=0;
	foreach($json as $v) {
		$list_index=1;
		foreach($v as $v1) {
			$i=0;
			foreach($v1 as $v2) {
				if($which_api==6) {
					//天脉接口计算
					if($i==9) {
						//echo $v2."\n";
						if($list_index ==count($v)&&!$curpos_sure) {
							//最后一个
							$pos = $list_index;
							$curpos_sure=true;
						}
						if(strtotime($cur)>strtotime($v2)) {
							//当前正在播放
							$curpos_sure=true;
						} else {
							if(curpos_sure) {
								$pos = $list_index;
								//echo  "qq";
								break;
							}
						}
					}
				} else {
					if($i==1) {
						//echo $v2."\n";
						if($list_index ==count($v)&&!$curpos_sure) {
							//最后一个
							$pos = $list_index;
							$curpos_sure=true;
						}
						if(strtotime($cur)<strtotime($v2)) {
							//当前正在播放
							$curpos_sure=true;
						} else {
							if(curpos_sure) {
								$pos = $list_index;
								//echo  "qq";
								break;
							}
						}
					}
				}
				$i++;
			}
			$list_index++;
		}
	}
	return ($pos-1);
}
//缓存EPG节目数据
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
//请求频道的EPG数据
function get_epg_data($tvid,$epgid,$name="",$date="") {
	if(strstr($epgid,"cntv") != false) {
		//电视家
		$url = "http://api.cntv.cn/epg/epginfo?serviceId=cbox&c=".substr($epgid, 5)."&d=".str_replace('-','',date('Y-m-d'));
		$str=curl::c()->set_ssl()->get($url);
		$re=json_decode($str,true);
		if (!empty($re[substr($epgid, 5)]['program'])) {
			$data=array("code"=>200,"msg"=>"请求成功!","name"=>$re[substr($epgid, 5)]['channelName'],"tvid"=>$tvid,"date"=>date('Y-m-d'));
			foreach($re[substr($epgid, 5)]['program'] as $row) {
				$data["data"][]= array("name"=> $row['t'],"starttime"=> $row['showTime']);
			}
			$data["pos"] = getPos($data);
			//当前播放位置
			return json_encode($data,JSON_UNESCAPED_UNICODE);
		}
		$data=["code"=>500,"msg"=>"请求失败!","name"=>$name,"date"=>null,"data"=>null];
		return json_encode($data,JSON_UNESCAPED_UNICODE);
	} else if(strstr($epgid,"jisu") != false) {
		//急速
		$appkey = "bbf19bcff8af8887";
		$url = "http://api.jisuapi.com/tv/query?appkey=".$appkey."&tvid=".substr($epgid, 5)."&date=".date('Y-m-d');
		$str=curl::c()->set_ssl()->get($url);
		$re=json_decode($str,true);
		if ($re["status"]==0) {
			$data=[];
			$data["code"]=200;
			$data["msg"]="请求成功!";
			$data["name"]=$re["result"]["name"];
			$data["tvid"]=$re["result"]["tvid"];
			$data["date"]=$re["result"]["date"];
			$data["data"]=$re["result"]["program"];
			return json_encode($data,JSON_UNESCAPED_UNICODE);
		}
		$data=["code"=>500,"msg"=>"请求失败!","name"=>$name,"date"=>null,"data"=>null];
		return json_encode($data,JSON_UNESCAPED_UNICODE);
	} else if(strstr($epgid,"tvsou") != false) {
		//tvsososos
		$wday = intval(date('w',strtotime(date('Y-m-d'))));
		if($wday == 0)
							$wday = 7;
		$url = "http://www.tvsou.com/epg/".substr($epgid, 6)."/w".$wday;
		$file=curl::c()->set_ssl()->get($url);
		//echo $url."------";
		$file=strstr($file,"<tbody>");
		$pos = strpos($file,"</tbody>");
		$file=substr($file,0,$pos);
		$file =  preg_replace(array("/<script[\s\S]*?<\/script>/i","/<a .*?href='(.*?)'.*?>/is","/<tbody>/i","/<\/a>/i"), '', $file);
		$file =  str_replace("</td><td></td></tr> ", '|', $file);
		$file =  str_replace("</td><td>", '#', $file);
		$file =  str_replace(array("<tr><td>","\r","\n","\r\n"," "), '', $file);
		$preview = substr($file,0,strlen($file)-1);
		//echo $preview."--------";
		if (!empty($preview)) {
			$data=array("code"=>200,"msg"=>"请求成功!","name"=>$name,"tvid"=>$tvid,"date"=>date('Y-m-d'));
			$preview =  str_replace("</td><tdstyle='width:100px;'></td></tr>", '|', $preview);
			$preview =  str_replace("</td><tdstyle='width:100px;'></td></tr", '', $preview);
			//echo $preview;
			$preview = explode('|',$preview);
			foreach($preview as $row) {
				$row1 = explode('#',$row);
				$data["data"][]= array("name"=> $row1[1],"starttime"=> $row1[0]);
			}
			$data["pos"] = getPos($data);
			//当前播放位置
			return json_encode($data,JSON_UNESCAPED_UNICODE);
			;
		}
		$data=["code"=>500,"msg"=>"请求失败!","name"=>$name,"date"=>null,"data"=>null];
		return json_encode($data,JSON_UNESCAPED_UNICODE);
	} else if(strstr($epgid,"tvmao") != false) {
		//电视猫
		$keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
		$wday = intval(date('w',strtotime(date('Y-m-d'))));
		if($wday == 0)
							$wday = 7;
		$str=curl::c()->set_ssl()->get("http://m.tvmao.com/program/".substr($epgid, 6)."-w".$wday.".html");
		//echo "https://m.tvmao.com/program/".substr($epgid, 6)."-w".$wday.".html"."------";
		preg_match('#action="/query.jsp" q="(\w+)" a="(\w+)"#',$str,$id);
		preg_match('#name="submit" id="(\w+)"#',$str,$id1);
		$str1=curl::c()->set_ssl()->get("http://m.tvmao.com/api/pg?p=".$keyStr[$wday*$wday].base64_encode($id1[1]."|".$id[2]).base64_encode("|".$id[1]));
		$str1 =  preg_replace(array('/<tr[^>]*>/i', '/<td[^>]*>/i','/<div[^>]*>/i','/<a[^>]*>/i'), '', $str1);
		$str1 =  str_replace("<\/a>", '', $str1);
		$str1 =  str_replace("<\/div><\/td>", '#', $str1);
		$str1 =  str_replace("<\/td><\/tr>", '|', $str1);
		$str1 =  str_replace('[1,"', '', $str1);
		$str1 =  str_replace('"]', '', $str1);
		$str1 =  str_replace('\n', '', $str1);
		$str1 = substr($str1,0,strlen($str1)-1);
		$preview = substr($str1,0,strlen($str1)-1);
		if (!empty($preview)) {
			$data=array("code"=>200,"msg"=>"请求成功!","name"=>$name,"tvid"=>$tvid,"date"=>date('Y-m-d'));
			$preview = explode('|',$preview);
			foreach($preview as $row) {
				$row1 = explode('#',$row);
				$data["data"][]= array("name"=> $row1[1],"starttime"=> $row1[0]);
			}
			$data["pos"] = getPos($data);
			//当前播放位置
			return json_encode($data,JSON_UNESCAPED_UNICODE);
		}
		$data=["code"=>500,"msg"=>"请求失败!","name"=>$name,"date"=>null,"data"=>null];
		return json_encode($data,JSON_UNESCAPED_UNICODE);
	} else if(strstr($epgid,"tvming") != false) {
		//天脉接口
		$url = "http://passport.live.tvmining.com/approve/epginfo?channel=";
		// 通过 php 的 file_get_contents 函数传给 $html 变量
		$html = file_get_contents($url.substr($epgid, 7));
		// 把字符串$html转为XML
		$xml = simplexml_load_string($html, 'SimpleXMLElement', LIBXML_NOCDATA);
		// 把XML转成数组$arr
		$arr = object_array($xml);
		foreach($arr["epg"] as &$epg) {
			foreach($epg["program"] as &$val) {
				$val["name"] = $val["title"];
				$val["starttime"] = date("H:i", $val["start_time"]);
			}
		}
		//unset($epg);
		//unset($val);
		//print_r($arr);
		// $arr["epg"][0]["date"] 里面的0代表今天
		// 改成1是昨天的 改成2是前天的
		// 最多改成6是一周前的
		$newar= array(
							"name" => $arr["channel"],
							"date" => $arr["epg"][0]["date"],
							"which" => 6,
							"data" => $arr["epg"][0]["program"]
							);
		// 把数组$arr转成json
		$data=array("code"=>200,"msg"=>"请求成功!","name"=>$name,"tvid"=>$tvid,"date"=>date('Y-m-d'));
		return json_encode($newar, JSON_UNESCAPED_UNICODE);
		
	} else if(strstr($epgid,"51zmt") != false) {
		$path = FCPATH  . 'bak/e.xml.gz';
		//定时删除文件
		$t = time();
		$start_a = "00:01";
		$start_b = "00:30";
		$a_t = strtotime($start_a);
		$b_t = strtotime($start_b);
		if( $t<$a_t || $b_t<$t ) {
		} else {
			$files = glob(FCPATH  . 'bak/*');
			foreach($files as $file) {
				if (is_file($file)) {
					@unlink($file);
				}
			}
		}
		if (!file_exists($path)) {
			//xml
			$a = new getFile();
			$a->get('http://epg.51zmt.top:8000/e.xml.gz', 'bak', 'e.xml.gz', 1);
			ob_flush();
			flush();
		}
		if (!file_exists(FCPATH.'bak/e.xml')) {
			$z = new Unzip();
			$z->unzip_gz($path);
			ob_flush();
			flush();
		}
		$xml = simplexml_load_file(FCPATH.'bak/e.xml');
		$xml = json_encode($xml);
		$xml = json_decode($xml,true);
		$arr=$channel=$epgdata=$result=array();
		foreach($xml['channel'] as $row) {
			$channel['data'][] = array('id'=>$row['@attributes']['id'],'name'=>$row['display-name']);
		}
		foreach($channel['data'] as $key => $value) {
			foreach ($value as $valu) {
				if(substr($epgid, 6) == $valu) {
					array_push($arr,$key);
				}
			}
		}
		foreach ($arr as $key => $value) {
			if(array_key_exists($value,$channel['data'])) {
				array_push($result, $channel['data'][$value]);
			}
		}
		foreach($xml['programme'] as $row) {
			$epgdata[] = array('id'=>$row['@attributes']['channel'],"start"=>$row['@attributes']['start'],'title'=>$row['title']);
		}
		if (!empty($epgdata)) {
			$data=array("code"=>200,"msg"=>"请求成功!","name"=>$name,"tvid"=>$tvid,"date"=>date('Y-m-d'));
			foreach($epgdata as $row) {
				if($row['id'] == $result[0]['id']) {
					$data["data"][]= array("name"=> $row['title'],"starttime"=> preg_replace('{^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})(.*?)$}u', '$4:$5',$row["start"]));
				}
			}
			$data["pos"] = getPos($data);
			//当前播放位置
			return json_encode($data,JSON_UNESCAPED_UNICODE);
		}
		$data=["code"=>500,"msg"=>"请求失败!","name"=>$name,"date"=>null,"data"=>null];
		return json_encode($data,JSON_UNESCAPED_UNICODE);
	}
}
//xml频道映射对应表
function channel_xml($id) {
	$id=urldecode($id);
	$id=str_replace("[add]","+",$id);
	$arr_file="epg_channel_arr_xml.php";
	//映射文件是否存在
	if (!file_exists($arr_file)) {
		$data=["code"=>500,"msg"=>"文件获取失败!","name"=>null,"date"=>null,"data"=>null];
		exit(json_encode($data,JSON_UNESCAPED_UNICODE));
	}
	//加载映射数组文件
	include ($arr_file);
	//echo json_encode(($arr[$id]),JSON_UNESCAPED_UNICODE);
	if (empty($arr)) {
		$data=["code"=>500,"msg"=>"频道列表获取失败!","name"=>null,"date"=>null,"data"=>null];
		exit(json_encode($data,JSON_UNESCAPED_UNICODE));
	} elseif (empty($arr[$id]["tvid"])) {
		$data=["code"=>500,"msg"=>"频道不存在!","name"=>null,"date"=>null,"data"=>null];
		exit(json_encode($data,JSON_UNESCAPED_UNICODE));
	}
	return $arr[$id];
}
//频道映射对应表
function channel_sql($id){

	global $con;
	$id=urldecode($id);

	$sql ="select * FROM iptv_epg where status=1 AND FIND_IN_SET('$id',content)";
	$result =mysqli_query($GLOBALS['conn'],"select * FROM iptv_epg where FIND_IN_SET('$id',content)");

	if($row=mysqli_fetch_array($result)){
		return $row;
		mysqli_close($GLOBALS['conn']);
		
	}else{
		$data=["code"=>500,"msg"=>"频道不存在!","name"=>null,"date"=>null,"data"=>null];
	    exit(json_encode($data,JSON_UNESCAPED_UNICODE));
	}
} 
//工具而已
function object_array($array) {
	//天脉工具
	if(is_object($array)) {
		$array = (array)$array;
	}
	if(is_array($array)) {
		foreach($array as $key=>$value) {
			$array[$key] = object_array($value);
		}
	}
	return $array;
}
?>