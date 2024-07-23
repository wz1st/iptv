<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

if ($_SESSION['author'] == 0) {
    exit("<script>$.alert({title: '警告',content: '你无权访问此页面。',type: 'orange',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){history.go(-1);}}}});</script>");
} 

?>

<?php 
// 删除用户
if (isset($_POST['submitdel'])) {
    foreach ($_POST['id'] as $id) {
        $db->mDel("iptv_users", "where name=$id");
        echo "<script>lightyear.notify('用户$id 已删除！', 'success', 3000);</script>";
    } 
} 
// 授权用户
if (isset($_POST['submitauthor'])) {
    $meals = (array_filter($_POST['meal_s']));
    if (empty($_POST['id']) || empty($_POST['meal_s'])) {
        echo"<script>lightyear.notify('请选择要授权的账号和套餐！', 'danger', 3000);</script>";
    } elseif (count($meals) != count($_POST['id'])) {
        echo"<script>lightyear.notify('授权的账号与套餐的记录不匹配！', 'danger', 3000);</script>";
    } else {
        $meals = array_values($meals);
        foreach($_POST['id']as $userid => $id) {
            $administrator = $_SESSION['user'];
            $nowtime = time();
            $exp = strtotime(date("Y-m-d"), time()) + 86400 * $_POST['exp'];
            if (empty($meals[$userid])) {
                $meal = 1000;
            } else {
                $meal = $meals[$userid];
            } 
            $db->mSet("iptv_users", "status=1,exp=$exp,author='$administrator',authortime=$nowtime,marks='已授权',meal='$meal'", "where name='$id'");
        } 
        unset($meals);
        echo "<script>$.alert({title: '成功',content: '选中用户已授权" . $_POST['exp'] . "天。',type: 'green',buttons: {confirm: {text: '好',btnClass: 'btn-primary',action: function(){window.location.href='useradmin.php';}}}});</script>";
    } 
} 
// 授权用户永不到期
if (isset($_POST['submitauthorforever'])) {
    $meals = (array_filter($_POST['meal_s']));
    if (empty($_POST['id']) || empty($_POST['meal_s'])) {
        echo"<script>lightyear.notify('请选择要永久授权的账号和套餐！', 'danger', 3000);</script>";
    } elseif (count($meals) != count($_POST['id'])) {
        echo"<script>lightyear.notify('永久授权的账号与套餐的记录不匹配！', 'danger', 3000);</script>";
    } else {
        $meals = array_values($meals);
        foreach($_POST['id']as $userid => $id) {
            $exp = strtotime(date("Y-m-d"), time()) + 86400 * 999;
            $administrator = $_SESSION['user'];
            $nowtime = time();
            if (empty($meals[$userid])) {
                $meal = 1000;
            } else {
                $meal = $meals[$userid];
            } 
            $db->mSet("iptv_users", "status=999,exp=$exp,author='$administrator',authortime=$nowtime,marks='已授权',meal='$meal'", "where name='$id'");
        } 
        unset($meals);
        echo"<script>$.alert({title: '成功',content: '选中用户已授权为永不到期。',type: 'green',buttons: {confirm: {text: '好',btnClass: 'btn-primary',action: function(){window.location.href='useradmin.php';}}}});</script>";
    } 
} 
// 禁用用户
if (isset($_POST['submitforbidden'])) {
    if (empty($_POST['id'])) {
        echo"<script>lightyear.notify('请选择要禁用的账号！', 'danger', 3000);</script>";
    } else {
        foreach ($_POST['id'] as $id) {
            $exp = strtotime(date("Y-m-d"), time());
            $administrator = $_SESSION['user'];
            $db->mSet("iptv_users", "status=0", "where name='$id'");
            echo "<script>lightyear.notify('用户$id 已被禁止试用！', 'success', 3000);</script>";
        } 
    } 
} 
// 删除一天前未授权用户
if (isset($_POST['submitdelonedaybefor'])) {
    $onedaybefore = strtotime(date("Y-m-d"), time());
    $db->mDel("iptv_users", "where status=-1 and lasttime<$onedaybefore");
    echo"<script>lightyear.notify('已删除一天前未授权用户！', 'success', 3000);</script>";
} 
// 删除所有未授权用户
if (isset($_POST['submitdelall'])) {
    $db->mDel("iptv_users", "where status=-1 or status=-999");
    echo"<script>lightyear.notify('已删除所有未授权用户！', 'success', 3000);</script>";
} 
// 搜索关键字
if (isset($_GET['keywords'])) {
    $keywords = trim($_GET['keywords']);
    $searchparam = "and (name like '%$keywords%' or mac like '%$keywords%' or deviceid like '%$keywords%' or model like '%$keywords%' or ip like '%$keywords%' or region like '%$keywords%' or status like '%$keywords%')";
} 
$keywords = trim($_GET['keywords']);
// 设置每页显示数量
if (isset($_POST['recCounts'])) {
    $recCounts = $_POST['recCounts'];
    $db->mSet("iptv_admin", "showcounts=$recCounts", "where name='$user'");
} 
// 获取每页显示数量
if ($row = $db->mGetRow("iptv_admin", "showcounts", "where name='$user'")) {
    $recCounts = $row['showcounts'];
} else {
    $recCounts = 100;
} 
unset($row);
// 获取当前页
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
} 
// 获取排序依据
if (isset($_GET['order'])) {
    $order = $_GET['order'];
} else {
    $order = 'lasttime desc';
} 
// 获取用户总数并根据每页显示数量计算页数
if ($row = $db->mGetRow("iptv_users", "count(*)", "where status=-1 or status=-999 or status=0")) {
    $userCount = $row[0];
    $pageCount = ceil($row[0] / $recCounts);
} else {
    $userCount = 0;
    $pageCount = 1;
} 
unset($row);
// 处理跳转逻辑
if (isset($_POST['jumpto'])) {
    $p = $_POST['jumpto'];
    if (($p <= $pageCount) && ($p > 0)) {
        echo "<script language=JavaScript>location.href='author.php' + '?page=$p&order=$order';</script>";
    } 
} 
// 获取当天上线用户总数
$todayTime = strtotime(date("Y-m-d"), time());
if ($row = $db->mGetRow("iptv_users", "count(*)", "where status=-1 or status=-999 and lasttime>$todayTime")) {
    $todayuserCount = $row[0];
} else {
    $todayuserCount = 0;
} 
unset($row);
// 获取当天授权用户总数
if ($row = $db->mGetRow("iptv_users", "count(*)", "where status>0 and authortime>$todayTime")) {
    $todayauthoruserCount = $row[0];
} else {
    $todayauthoruserCount = 0;
} 
unset($row);
// 获取授权开关状态试用天数
$needauthor = $db->mGet("iptv_config", "value", "where name='needauthor'");
$isfreeuser = $db->mGet("iptv_config", "value", "where name='trialdays'");

?>