<?php
session_start();
$db = Config::getIntance();

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    header("location:../index.php");
    exit();
} 

if ($row = $db->mGetRow("iptv_admin", "*", "where name='$user'")) {
    $psw = $row['psw'];
} else {
    $psw = '';
} 

if (!isset($_SESSION['psw']) || $_SESSION['psw'] != $psw) {
    header("location:../index.php");
    exit();
} 

?>
