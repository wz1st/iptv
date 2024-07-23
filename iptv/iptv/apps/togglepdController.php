<?php
require_once "../config.php";
$db = Config::GetIntance();

session_start();
if (isset($_SESSION['user']))$user = $_SESSION['user'];
if ($row = $db->mGetRow("iptv_admin", "*", "where name='$user'")) {
    $psw = $row['psw'];
} else {
    $psw = '';
} 
if (!isset($_SESSION['psw']) || $_SESSION['psw'] != $psw) {
    exit;
} 

?>

<?php
if (isset($_GET['cname'])) {
    $cname = $_GET['cname'];
    if ($row = $db->mGetRow("iptv_category", "enable", "where name='$cname'")) {
        if ($row['enable'] == 1) {
            $db->mSet("iptv_category", "enable=0", "where name='$cname'");
            echo "<script>alert('$cname 已禁用');</script>";
        } else {
            $db->mSet("iptv_category", "enable=1", "where name='$cname'");
            echo "<script>alert('$cname 已启用');</script>";
        } 
    } else {
        echo "<script>alert('$cname 操作失败！');</script>";
    } 
} else {
    echo "<script>alert('参数错误');</script>";
} 

?>