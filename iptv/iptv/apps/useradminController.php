<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

if ($_SESSION['useradmin'] == 0) {
    echo"<script>alert('你无权访问此页面！');history.go(-1);</script>";
} 

?>

<?php
if (isset($_POST['submitdelall'])) {
    $nowtime = time();
    $db->mDel("iptv_users", "where status=1 and exp<$nowtime");
    echo("<script>lightyear.notify('已清空所有过期用户！', 'success', 3000);</script>");
} 

if (isset($_POST['submitdel'])) {
    if (empty($_POST['id'])) {
        echo("<script>lightyear.notify('请选择要删除的用户账号！', 'danger', 3000);</script>");
    } else {
        foreach ($_POST['id'] as $id) {
            $db->mDel("iptv_users", "where name=$id");
            $db->mDel("iptv_loginrec", "where userid=$id");
        } 
        echo("<script>lightyear.notify('选中用户及其登陆信息已删除！', 'success', 3000);</script>");
    } 
} 
if (isset($_POST['submitmodify'])) {
    if (empty($_POST['id'])) {
        echo("<script>lightyear.notify('请选择要修改授权天数的用户账号！', 'danger', 3000);</script>");
    } else {
        $exp = strtotime(date("Y-m-d"), time()) + 86400 * $_POST['exp'];
        foreach ($_POST['id'] as $id) {
            $db->mSet("iptv_users", "status=1,exp=$exp", "where name=$id");
            echo("<script>lightyear.notify('用户$id 授权天数已修改！', 'success', 3000);</script>");
        } 
    } 
} 

if (isset($_POST['submitadddays'])) {
    if (empty($_POST['id'])) {
        echo("<script>lightyear.notify('请选择要增加授权天数的用户账号！', 'danger', 3000);</script>");
    } elseif (empty($_POST['exp'])) {
        echo("<script>lightyear.notify('请输入要增加的授权天数！', 'danger', 3000);</script>");
    } else {
        $expimportmac = $_POST['exp'];
        $exp = 86400 * $_POST['exp'];
        foreach ($_POST['id'] as $id) {
            $db->mSet("iptv_users", "exp=exp+$exp", "where name=$id and status=1");
            echo("<script>lightyear.notify('用户$id 授权天数已增加！', 'success', 3000);</script>");
        } 
    } 
} 

if (isset($_POST['submitmodifymarks'])) {
    if (empty($_POST['id'])) {
        echo("<script>lightyear.notify('请选择要修改备注的用户账号！', 'danger', 3000);</script>");
    } else {
        $marks = $_POST['marks'];
        foreach ($_POST['id'] as $id) {
            $db->mSet("iptv_users", "marks='$marks'", "where name=$id");
            echo("<script>lightyear.notify('用户$id 用户备注已修改！', 'success', 3000);</script>");
        } 
    } 
} 

if (isset($_POST['submitforbidden'])) {
    if (empty($_POST['id'])) {
        echo("<script>lightyear.notify('请选择要取消授权的用户账号！', 'danger', 3000);</script>");
    } else {
        foreach ($_POST['id'] as $id) {
            $db->mSet("iptv_users", "status=0,author='',authortime=0,meal=''", "where name=$id and (status=1 or status=999)");
        } 
        echo("<script>$.alert({title: '成功',content: '选中用户已取消授权。',type: 'green',buttons: {confirm: {text: '好',btnClass: 'btn-primary',action: function(){window.location.href='author.php';}}}});</script>");
    } 
} 

if (isset($_POST['submitNotExpired'])) {
    if (empty($_POST['id'])) {
        echo("<script>lightyear.notify('请选择要设置永不到期的用户账号！', 'danger', 3000);</script>");
    } else {
        foreach ($_POST['id'] as $id) {
            $db->mSet("iptv_users", "status=999", "where name=$id and status=1");
            echo("<script>lightyear.notify('用户$id 已设置为永不到期！', 'success', 3000);</script>");
        } 
    } 
} 

if (isset($_POST['submitCancelNotExpired'])) {
    if (empty($_POST['id'])) {
        echo("<script>lightyear.notify('请选择要取消永不到期的用户账号！', 'danger', 3000);</script>");
    } else {
        foreach ($_POST['id'] as $id) {
            $db->mSet("iptv_users", "status=1", "where name=$id and status=999");
            echo("<script>lightyear.notify('用户$id 已取消为永不到期！', 'success', 3000);</script>");
        } 
    } 
} 

if (isset($_POST["s_meals"]) && isset($_POST["e_meals"])) {
    if (empty($_POST["s_meals"])) {
        echo("<script>lightyear.notify('请选择要修改的套餐！', 'danger', 3000);</script>");
    } elseif (empty($_POST['id'])) {
        echo("<script>lightyear.notify('请选择要修改套餐的用户账号信息！', 'danger', 3000);</script>");
    } else {
        foreach($_POST["id"]as $mealid => $userid) {
            $db->mSet("iptv_users", "meal=" . $_POST["s_meals"], "where name='$userid'");
            echo("<script>lightyear.notify('用户$userid 已修改套餐！', 'success', 3000);</script>");
        } 
    } 
} 

if (isset($_POST['recCounts'])) {
    $recCounts = $_POST['recCounts'];
    $db->mSet("iptv_admin", "showcounts=$recCounts", "where name='$user'");
} 
// 搜索关键字
if (isset($_GET['keywords'])) {
    $keywords = trim($_GET['keywords']);
    $searchparam = "and (name like '%$keywords%' or deviceid like '%$keywords%' or mac like '%$keywords%' or name like '%$keywords%' or model like '%$keywords%' or ip like '%$keywords%' or region like '%$keywords%' or author like '%$keywords%' or marks like '%$keywords%' or status like '%$keywords%')";
} 
$keywords = trim($_GET['keywords']);
// 获取每页显示数量
if ($row = $db->mGetRow("iptv_admin", "showcounts", "where name='$user'")) {
    $recCounts = $row['showcounts'];
} else {
    $recCounts = 100;
} 
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
if ($row = $db->mGetRow("iptv_users", "count(*)", "where status>-1")) {
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
        echo "<script language=JavaScript>location.href='useradmin.php' + '?page=$p&order=$order';</script>";
    } 
} 
// 获取当天上线用户总数
$todayTime = strtotime(date("Y-m-d"), time());
if ($row = $db->mGetRow("iptv_users", "count(*)", "where status>-1 and lasttime>$todayTime")) {
    $todayuserCount = $row[0];
} else {
    $todayuserCount = 0;
} 
unset($row);
// 获取当天授权用户总数
if ($row = $db->mGetRow("iptv_users", "count(*)", "where status>-1 and authortime>$todayTime")) {
    $todayauthoruserCount = $row[0];
} else {
    $todayauthoruserCount = 0;
} 
unset($row);
// 获取过期用户
$nowTime = time();
if ($row = $db->mGetRow("iptv_users", "count(*)", "where status=1 and exp<$nowTime")) {
    $expuserCount = $row[0];
} else {
    $expuserCount = 0;
} 
unset($row);

?>