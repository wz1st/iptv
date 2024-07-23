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
header("Content-type:text/json;charset=utf-8");

function echoSource($category) {
    global $db;
    $db->mQuery("SET NAMES UTF8");
    $result = $db->mQuery("SELECT distinct id,name,url FROM iptv_channels where category='$category' order by id");
    while ($row = mysqli_fetch_array($result)) {
        echo $row['name'] . "," . $row['url'] . "\n";
    } 
    unset($row);
    mysqli_free_result($result);
} 

if (isset($_GET['category'])) {
    $category = $_GET['category'];
} else {
    $category = '未知';
} 

echoSource($category);

?>