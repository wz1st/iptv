<?php
ini_set('display_errors',1);            
ini_set('display_startup_errors',1);   
error_reporting(E_ERROR);

include_once "../../conn.php";

/**
 * 映射外键参数与代理接口参数
 * 
		'CCTV-1综合'=> array('tvid'=> 10001 , 'epgid'=> 'cntv-cctv1'),
 */
    $arr = array();
    $sql = "SELECT id,name,content,beizhu FROM iptv_epg where status=1";
	$result = mysqli_query($con,$sql);
	while($row =mysqli_fetch_array($result)) {	
		$data=$row['content'].',';
		$arrData=explode(",",$data);
		for($x=0;$x<count($arrData);$x++) {
			if($arrData[$x]!='')$arr[$arrData[$x]]=array('tvid'=> $row['id'] , 'epgid'=> $row['name']);
		}
		
	}
	mysqli_free_result($result);
	
?>
