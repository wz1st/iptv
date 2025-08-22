<?php
include_once "config.php";
$db = Config::GetIntance();

$id=@$_GET['id'];
$db->mSet("iptv_users", "vpn=vpn+1", "where name=$id");
?>