<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

require_once "../config.php";
require_once "alipay/notify.class.php";
$db = Config::GetIntance();

$alipayPublicKey = $db->mGet("iptv_config", "value", "where name='alipay_publickey'");  //支付宝公钥

$notify = new NotifyService($alipayPublicKey);
$notifyres = $notify->rsaCheck($_POST,$_POST['sign_type']);  //验证签名
if($notifyres===true){
    //处理你的逻辑，例如获取订单号$_POST['out_trade_no']，订单金额$_POST['total_amount']
    $nowtime = time();
    $postid=$_POST['out_trade_no'];
	if ($row = $db->mGetRow("iptv_payment", "userid,meal,days", "where order_id='$postid'")) {
		$days=$row['days'];
		$meal=$row['meal'];
		$userid=$row['userid'];
	    $exp = strtotime(date("Y-m-d"), time()) + 86400 * $days;
	    $db->mSet("iptv_payment", "status=1", "where order_id='$postid'");
	    if ($days == 999){
	    	$db->mSet("iptv_users", "status=999,exp=$exp,author='支付宝',authortime=$nowtime,marks='已支付',meal='$meal'", "where name='$userid'");
	    } else {
	    	$db->mSet("iptv_users", "status=1,exp=$exp,author='支付宝',authortime=$nowtime,marks='已支付',meal='$meal'", "where name='$userid'");
	    }
	    exit('success') ;
	} else {
	    exit('error') ;
	} 
}
exit('error') ;

?>