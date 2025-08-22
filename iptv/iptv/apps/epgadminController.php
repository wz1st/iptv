<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

if ($_SESSION['epgadmin'] == 0) {
    exit("<script>$.alert({title: '警告',content: '你无权访问此页面。',type: 'orange',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){history.go(-1);}}}});</script>");
} 

?>

<?php 
// 清除EPG缓存
if (isset($_POST['clearcache'])) {
    $num = 0;
    $files = glob("../epg/cache/*");
    $files_api = glob("../api/epg/cache/*");//api目录里的缓存
    foreach ($files as $file) {
        unlink($file);
        $num++;
    } 
    foreach ($files_api as $file) {
        unlink($file);
        $num++;
    } 
    exit("<script>$.alert({title: '成功',content: '已清除" . $num . "个EPG缓存文件！',type: 'green',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
} 
// 清除频道绑定
if (isset($_POST['clearbind'])) {
    if (isset($_POST['id'])) {
        $where = "where id=" . $_POST['id'];
    } 
    $db->mSet("iptv_epg", "content=NULL", $where);
    exit("<script>$.alert({title: '成功',content: '已清除绑定频道！',type: 'green',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
} 
// 绑定频道
if (isset($_POST['bindchannel'])) {
    $result = $db->mQuery("SELECT distinct name FROM iptv_channels");
    if (!mysqli_num_rows($result)) {
        mysqli_free_result($result);
        exit("<script>$.alert({title: '错误',content: '对不起，暂时没有频道信息，无法匹配！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    } 

    $clist = []; // 创建一个空数组来存储频道名称
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $clist[] = $row;
    } 
    unset($row);
    mysqli_free_result($result);

    if (isset($_POST['id'])) {
        if ($_POST["remarks"] == '') {
            exit("<script>$.alert({title: '错误',content: '对不起，备注信息不完整，无法匹配！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
        }
        $result = explode('|', $_POST['remarks']); // 分解用户输入的多个关键词，存入$result数组
        $list = []; // 创建一个空数组来存储匹配到的频道名称
        foreach ($result as $keyword) {
            foreach ($clist as $cname => $channel) {
                if (strstr($channel['name'], $keyword) !== false) {
                    // 判断关键字后面一位是否符合要求
                    if (!preg_match('/[0-9\+K]$/', $channel['name'][strpos($channel['name'], $keyword) + strlen($keyword)])) {
                        $list[$cname] = $channel['name'];
                    }
                } 
            } 
        } // 结束
        
        $content = implode(",", array_unique($list));
        if (empty($content)) {
            exit("<script>$.alert({title: '错误',content: '对不起，没有索引到频道列表！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
        } 
        $db->mSet("iptv_epg", "content=".$db->safeSQLParam($content), "where id=" . $_POST['id']);
        exit("<script>$.alert({title: '成功',content: 'EPG信息已匹配！',type: 'green',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    } 

    $result = $db->mQuery("SELECT id,remarks,content from iptv_epg where remarks != ''");
    if (!mysqli_num_rows($result)) {
        mysqli_free_result($result);
        exit("<script>$.alert({title: '错误',content: '对不起，暂时没有EPG信息，无法匹配！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    } 

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $result_remarks = explode('|', $row['remarks']); // 分解用户输入的多个关键词，存入$result数组
        $list = []; // 创建一个空数组来存储匹配到的频道名称
        foreach ($result_remarks as $keyword) {
            foreach ($clist as $cname => $channel) {
                if (strstr($channel['name'], $keyword) !== false) {
                    // 判断关键字后面一位是否符合要求
                    if (!preg_match('/[0-9\+K]$/', $channel['name'][strpos($channel['name'], $keyword) + strlen($keyword)])) {
                        $list[$cname] = $channel['name'];
                    }
                } 
            } 
        }
        $content = implode(",", array_unique($list));
        $db->mSet("iptv_epg", "content=".$db->safeSQLParam($content), "where id=" . $row['id']);
        unset($list, $result_remarks);
    } 
    unset($row);
    mysqli_free_result($result);
    exit("<script>$.alert({title: '成功',content: 'EPG信息已匹配！',type: 'green',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
}
// 上线操作
if ($_GET["act"] == "online") {
    $id = !empty($_GET["id"])?$_GET["id"]:exit("<script>$.alert({title: '错误',content: '参数不能为空！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    $db->mSet("iptv_epg", "status=1", "where id=$id");
    exit("<script>$.alert({title: '成功',content: 'EPG编号 " . $id . " 已上线！',type: 'green',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
} 
// 下线操作
if ($_GET["act"] == "downline") {
    $id = !empty($_GET["id"])?$_GET["id"]:exit("<script>$.alert({title: '错误',content: '参数不能为空！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    $db->mSet("iptv_epg", "status=0", "where id=$id");
    exit("<script>$.alert({title: '成功',content: 'EPG编号 " . $id . " 已下线！',type: 'green',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
} 
// 删除操作
if ($_GET["act"] == "dels") {
    $id = !empty($_GET["id"])?$_GET["id"]:exit("<script>$.alert({title: '错误',content: '参数不能为空！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    $db->mDel("iptv_epg", "where id=$id");
    exit("<script>$.alert({title: '成功',content: 'EPG编号 " . $id . " 已删除！',type: 'green',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
} 
// 新增EPG数据
if ($_GET["act"] == "add") {
    $epg = !empty($_POST["epg"])?$_POST["epg"]:exit("<script>$.alert({title: '错误',content: '请选择EPG来源！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    $name = !empty($_POST["name"])?$_POST["name"]:exit("<script>$.alert({title: '错误',content: '请填写EPG名称！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    $remarks = $_POST["remarks"];
    $epg_name = $epg . '-' . $name;
    $result = $db->mQuery("select * from iptv_epg where name=" . $db->safeSQLParam($epg_name)); 
    // EPG是否已经同名或存在
    if (mysqli_num_rows($result)) {
        mysqli_free_result($result);
        exit("<script>$.alert({title: '错误',content: 'EPG名为 " . $epg_name . " 已存在，请不要重复新增！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    } 
    // 新加EPG数据
    $db->mInt("iptv_epg", "name,remarks", "'" . $epg_name . "','" . $remarks . "'");
    exit("<script>$.alert({title: '成功',content: 'EPG " . $epg_name . " 已增加！',type: 'green',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
} 
// EPG接口验证
if (isset($_POST['submitepgapi_chk'])) {
    $tipepgerror_1000 = $_POST['tipepgerror_1000'];
    $tipepgerror_1001 = $_POST['tipepgerror_1001'];
    $tipepgerror_1002 = $_POST['tipepgerror_1002'];
    $tipepgerror_1003 = $_POST['tipepgerror_1003'];
    $tipepgerror_1004 = $_POST['tipepgerror_1004'];
    $tipepgerror_1005 = $_POST['tipepgerror_1005'];
    if (isset($_POST['epgapi_chk'])) {
        $epgapi_chk = 1;
    } else {
        $epgapi_chk = 0;
    } 
    $db->mSet("iptv_config", "value='$tipepgerror_1000'", "where name='tipepgerror_1000'");
    $db->mSet("iptv_config", "value='$tipepgerror_1001'", "where name='tipepgerror_1001'");
    $db->mSet("iptv_config", "value='$tipepgerror_1002'", "where name='tipepgerror_1002'");
    $db->mSet("iptv_config", "value='$tipepgerror_1003'", "where name='tipepgerror_1003'");
    $db->mSet("iptv_config", "value='$tipepgerror_1004'", "where name='tipepgerror_1004'");
    $db->mSet("iptv_config", "value='$tipepgerror_1005'", "where name='tipepgerror_1005'");
    $db->mSet("iptv_config", "value='$epg_api_chk'", "where name='epg_api_chk'");
    exit("<script>$.alert({title: '成功',content: '设置已保存！',type: 'green',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
} 
// 初始化数据
$epg_api_chk = $db->mGet("iptv_config", "value", "where name='epg_api_chk'");
if ($epg_api_chk == 1) {
    $epg_api_chk = 'checked="checked"';
} else {
    $epg_api_chk = "";
} 
$tipepgerror_1000 = $db->mGet("iptv_config", "value", "where name='tipepgerror_1000'");
$tipepgerror_1001 = $db->mGet("iptv_config", "value", "where name='tipepgerror_1001'");
$tipepgerror_1002 = $db->mGet("iptv_config", "value", "where name='tipepgerror_1002'");
$tipepgerror_1003 = $db->mGet("iptv_config", "value", "where name='tipepgerror_1003'");
$tipepgerror_1004 = $db->mGet("iptv_config", "value", "where name='tipepgerror_1004'");
$tipepgerror_1005 = $db->mGet("iptv_config", "value", "where name='tipepgerror_1005'");
// 搜索关键字
if (isset($_GET['keywords'])) {
    $keywords = $_GET['keywords'];
    $searchparam = "where name like '%$keywords%' or remarks like '%$keywords%' or content like '%$keywords%'";
} 
// 设置每页显示数量
if (isset($_POST['recCounts'])) {
    $recCounts = $_POST['recCounts'];
    $db->mSet("iptv_admin", "showcounts=$recCounts", "where name=".$db->safeSQLParam($user));
} 
// 获取当前页
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
} 
// 获取每页显示数量
if ($row = $db->mGetRow("iptv_admin", "showcounts", "where name=".$db->safeSQLParam($user))) {
    $recCounts = $row['showcounts'];
} else {
    $recCounts = 100;
} 
// 获取EPG总数并根据每页显示数量计算页数
if ($row = $db->mGetRow("iptv_epg", "count(*)")) {
    $pageCount = ceil($row[0] / $recCounts);
} else {
    $pageCount = 1;
} 
// 处理跳转逻辑
if (isset($_POST['jumpto'])) {
    $p = $_POST['jumpto'];
    if (($p <= $pageCount) && ($p > 0)) {
        echo "<script>location.href='epgadmin.php' + '?page=$p';</script>";
    } 
} 

?>