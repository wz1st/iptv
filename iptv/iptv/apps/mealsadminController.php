<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

if ($_SESSION['mealsadmin'] == 0) {
    exit("<script>$.alert({title: '警告',content: '你无权访问此页面。',type: 'orange',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: //function(){history.go(-1);}}}});</script>");
}

?>

<?php 
// 上线操作
if ($_GET["act"] == "online") {
    $id = !empty($_GET["id"])?$_GET["id"]:exit("<script>$.alert({title: '错误',content: '套餐参数为空！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    $db->mSet("iptv_meals", "status=1", "where id=$id");
    exit("<script>$.alert({title: '成功',content: '套餐编号 " . $id . " 已上线！',type: 'green',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
} 
// 下线操作
if ($_GET["act"] == "downline") {
    $id = !empty($_GET["id"])?$_GET["id"]:exit("<script>$.alert({title: '错误',content: '套餐参数为空！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    if ($id == 1000)exit("<script>$.alert({title: '错误',content: '默认套餐不能操作下线处理！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    $db->mSet("iptv_meals", "status=0", "where id=$id");
    exit("<script>$.alert({title: '成功',content: '套餐编号 " . $id . " 已下线！',type: 'green',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
} 
// 删除操作
if ($_GET["act"] == "dels") {
    $id = !empty($_GET["id"])?$_GET["id"]:exit("<script>$.alert({title: '错误',content: '套餐参数为空！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    if ($id == 1000)exit("<script>$.alert({title: '错误',content: '默认套餐不能删除！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    $db->mDel("iptv_meals", "where id=$id");
    exit("<script>$.alert({title: '成功',content: '套餐编号 " . $id . " 已删除！',type: 'green',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
} 
// 新增套餐数据
if ($_GET["act"] == "add") {
    $meal_name = !empty($_POST["name"])?$_POST["name"]:exit("<script>$.alert({title: '错误',content: '请填写套餐名称！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    $result = $db->mQuery("select * from iptv_meals where name=" . "'" . $meal_name . "'"); 
    // 套餐是否已经同名或存在
    if (mysqli_num_rows($result)) {
		mysqli_free_result($result);
        exit("<script>$.alert({title: '错误',content: '套餐名为 " . $meal_name . " 已存在，请不要重复新增！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    } 
    // 验证套餐是否在20个以个
    $count = $db->mGet("iptv_meals", "count(name)");
    if ($count >= 20) {
        exit("<script>$.alert({title: '错误',content: '当前套餐已经达到20个的上限！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    } 
    // 新加套餐数据
    $db->mInt("iptv_meals", "name", "'$meal_name'");
    exit("<script>$.alert({title: '成功',content: '套餐 " . $meal_name . " 已增加！',type: 'green',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
} 
// 检测默认套餐是否存在，如不存在自动建立默认套餐
$mealchk = $db->mQuery("SELECT id form meals where id=1000");
if (empty($mealchk)) {
    $db->mInt("iptv_meals", "id,name,content,status", "1000,'默认套餐','',1");
} 

?>