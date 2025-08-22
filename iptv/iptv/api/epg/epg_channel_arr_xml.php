<?php
ini_set('display_errors',1);            
ini_set('display_startup_errors',1); 
error_reporting(E_ERROR);
$doc = new DOMDocument();
$doc->load( 'epg.xml' );
$epgs = $doc->getElementsByTagName( "epg" );
$arr = array();
foreach( $epgs as $epg )
{
	
$tvidTag = $epg->getElementsByTagName( "tvid" );
$tvid = $tvidTag->item(0)->nodeValue;

$epgidTag = $epg->getElementsByTagName( "epgid" );
$epgid = $epgidTag->item(0)->nodeValue;


$nameTag = $epg->getElementsByTagName( "name" );
$name = $nameTag->item(0)->nodeValue;

$statusTag = $epg->getElementsByTagName( "status" );
$status = $statusTag->item(0)->nodeValue;

if($status!=1&&$status!="1")continue;

		$data=$name.',';
		$arrData=explode(",",$data);
		for($x=0;$x<count($arrData);$x++) {
			if($arrData[$x]!='')$arr[$arrData[$x]]=array('tvid'=> $tvid , 'epgid'=> $epgid);
		}
}
?>