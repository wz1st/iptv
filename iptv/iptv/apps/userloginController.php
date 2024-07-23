<?php
ini_set("error_reporting", "E_ALL & ~E_NOTICE");

session_start();
require_once "config.php";
$GetIP = new GetIP();
$db = Config::GetIntance();

$ip=$GetIP->getuserip();
if ($ip=='' || $ip=='127.0.0.1' || $ip=='::1') {
	$ip='127.0.0.1';
	$region='localhost';
} else {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' || 
                isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ||
                isset($_SERVER['HTTP_FRONT_END_HTTPS']) && $_SERVER['HTTP_FRONT_END_HTTPS'] === 'on' ? 'https://' : 'http://';
    $myurl = $protocol . $_SERVER['HTTP_HOST'] . '/iptv';
    $json = file_get_contents("$myurl/getIpInfo.php?ip=$ip");
    $obj = json_decode($json);
    if (empty($obj->data->region)) {
        $region = "未知";
    } else {
        $region = $obj->data->region . $obj->data->city . $obj->data->isp;
    }
} 
$time = date("Y-m-d H:i:s");

$getkey =  $db->mGet("iptv_config","value","where name='secret_key'");
if (empty($getkey)) {
        $_SESSION['secret_key_status'] = '1';}
        
if (isset($_COOKIE['remembersecret_key'])) {
    $secret_key = $db->mEscape_string($_COOKIE['secret_key']);
    if ($secret_key == $getkey) {
        $_SESSION['secret_key_status'] = '1';
    } 
} 

if (isset($_COOKIE['rememberpass'])) {
    $user = $db->mEscape_string($_COOKIE['username']);
    $psw = $db->mEscape_string($_COOKIE['password']);
    if ($row = $db->mGetRow("iptv_admin","*","where name='$user'")) {
        if ($psw == $row['psw']) {
            $_SESSION['user'] = $user;
            $_SESSION['psw'] = $psw;
            $_SESSION['author'] = $row['author'];
            $_SESSION['useradmin'] = $row['useradmin'];
            $_SESSION['ipcheck'] = $row['ipcheck'];
            $_SESSION['epgadmin'] = $row['epgadmin'];
            $_SESSION['mealsadmin'] = $row['mealsadmin'];
            $_SESSION['channeladmin'] = $row['channeladmin'];
            $db->mInt("iptv_adminrec","id,name,ip,loc,time,func","null,'$user','$ip','$region','$time','用户登入'");
            header("location:views/index.php");
        } 
    }
	unset($row);
} 

if (isset($_POST['secret_key_enter'])) {
    $secret_key = $_POST['secret_key'];
    $secret_key = $db->mEscape_string($_POST['secret_key']);
    $secret_key = md5($secret_key);
    if ($secret_key == $getkey) {
        if (isset($_POST['remembersecret_key'])) {
            setcookie("secret_key", $getkey, time() + 3600 * 24 * 7, "/");
            setcookie("remembersecret_key", "1", time() + 3600 * 24 * 7, "/");
        } else {
            setcookie("remembersecret_key", "1", time()-3600, "/");
        } 
        $_SESSION['secret_key_status'] = '1';
    } else {
        echo "<script>alert('安全码错误！');</script>";
    }
} 

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $user = $db->mEscape_string($_POST['username']);
    $psw = $db->mEscape_string($_POST['password']);
    $psw = md5(PANEL_MD5_KEY . $psw);
    if ($row = $db->mGetRow("iptv_admin","*","where name='$user'")) {
        if ($psw == $row['psw']) {
            $user = $row['name'];
            $_SESSION['user'] = $user;
            $_SESSION['psw'] = $row['psw'];
            $_SESSION['author'] = $row['author'];
            $_SESSION['useradmin'] = $row['useradmin'];
            $_SESSION['ipcheck'] = $row['ipcheck'];
            $_SESSION['epgadmin'] = $row['epgadmin'];
            $_SESSION['mealsadmin'] = $row['mealsadmin'];
            $_SESSION['channeladmin'] = $row['channeladmin'];
            if (isset($_POST['rememberpass'])) {
                setcookie("username", $user, time() + 3600 * 24 * 7, "/");
                setcookie("password", $row['psw'], time() + 3600 * 24 * 7, "/");
                setcookie("rememberpass", "1", time() + 3600 * 24 * 7, "/");
            } else {
                setcookie("rememberpass", "1", time()-3600, "/");
            } 
            $db->mInt("iptv_adminrec","id,name,ip,loc,time,func","null,'$user','$ip','$region','$time','用户登入'");
            header("location:views/index.php");
        } else {
            echo "<script>alert('密码错误！');</script>";
            $db->mInt("iptv_adminrec","id,name,ip,loc,time,func","null,'$user','$ip','$region','$time','输入错误密码'");
        } 
    } else {
        echo "<script>alert('用户不存在！');</script>";
        $db->mInt("iptv_adminrec","id,name,ip,loc,time,func","null,'$user','$ip','$region','$time','尝试登陆'");
    }
	unset($row);
} 

?>