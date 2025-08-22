<?php
date_default_timezone_set('PRC'); 
function object_array($array){
  if(is_object($array)){
    $array = (array)$array;
  }
  if(is_array($array)){
    foreach($array as $key=>$value){
      $array[$key] = object_array($value);
    }
  }
  return $array;
}
header("content-type:application/json;charset=utf-8");
$url = "http://passport.live.tvmining.com/approve/epginfo?channel=";
// 通过 php 的 file_get_contents 函数传给 $html 变量
$html = file_get_contents($url.$_GET['id']);
// 把字符串$html转为XML
$xml = simplexml_load_string($html, 'SimpleXMLElement', LIBXML_NOCDATA);
// 把XML转成数组$arr
$arr = object_array($xml);
foreach($arr["epg"] as &$epg){
  foreach($epg["program"] as &$val){
    $val["starttime"] = date("H:i", $val["start_time"]);
	 $val["starttimeTag"] = date("Y-m-d H:i:s", $val["start_time"]);
	$val["name"] = $val["title"];
  }
}
unset($epg);
unset($val);
//print_r($arr);
// $arr["epg"][0]["date"] 里面的0代表今天
// 改成1是昨天的 改成2是前天的
// 最多改成6是一周前的
$arr = array(
	"code"=>200,
  "name" => $arr["channel"],
  "date" => $arr["epg"][0]["date"],
  "data" => $arr["epg"][0]["program"],
  "pos"=> getPos($arr["epg"][0]["program"])
);
// 把数组$arr转成json
$json = json_encode($arr, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
echo $json;

function getPos($json){
	$curpos_sure=false;
	$cur=date("Y-m-d H:i:s"); 
	$pos=0;
	foreach($json as $v){
		$list_index=1;
		$i=0;
			foreach($v as $v1){
				//$i=0;
				//echo $v1."\n";
						if($i==9){
							//echo $v1."------".$cur."\n";
							//if($list_index ==count($json)&&!$curpos_sure){//最后一个
								//$pos = $list_index;
								//$curpos_sure=true;
							//}
							if(strtotime($cur)>strtotime($v1)){  //当前正在播放
								$curpos_sure=true;
							}else{
								if(curpos_sure){
									$pos = $list_index;
									//echo  "qq";
									break;
								}
							}
				
				}
				$i++;
		$list_index++;
			}
			
	}
	return ($pos);
}
?>