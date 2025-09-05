<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

if ($user != 'admin') {
    exit("<script>$.alert({title: '警告',content: '你无权访问此页面。',type: 'orange',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){history.go(-1);}}}});</script>");
} 

?>

<?php 
// 修改密码操作
if (isset($_POST['submit']) && isset($_POST['newpassword'])) {
    if (empty($_POST['oldpassword']) || empty($_POST['newpassword'])) {
        echo"<script>showindex=3;lightyear.notify('密码不能为空！', 'danger', 3000);</script>";
    } else {
        $username = $_POST['username'];
        $oldpassword = md5(PANEL_MD5_KEY . $_POST['oldpassword']);
        $newpassword = md5(PANEL_MD5_KEY . $_POST['newpassword']);
        $result = $db->mGetRow("iptv_admin", "*", "where name='$username' and psw='$oldpassword'");
        if ($result) {
            $db->mSet("iptv_admin", "psw='$newpassword'", "where name='$username'");
            echo"<script>showindex=3;lightyear.notify('密码修改成功！', 'success', 3000);</script>";
        } else {
            echo"<script>showindex=3;lightyear.notify('原始密码不匹配！', 'danger', 3000);</script>";
        } 
    } 
} 
// 修改安全码操作
if (isset($_POST['submit']) && isset($_POST['newsecret_key'])) {
    if (empty($_POST['newsecret_key']) || empty($_POST['newsecret_key_confirm'])) {
        echo"<script>showindex=3;lightyear.notify('安全码不能为空！', 'danger', 3000);</script>";
    } else {
        $newsecret_key_input = $_POST['newsecret_key'];
        $newsecret_key_confirm = $_POST['newsecret_key_confirm'];
        if ($newsecret_key_input == $newsecret_key_confirm) {
            $newsecret_key = md5($_POST['newsecret_key']);
            $db->mSet("iptv_config", "value='$newsecret_key'", "where name='secret_key'");
            echo"<script>showindex=3;lightyear.notify('安全码修改成功！', 'success', 3000);</script>";
        } else {
            echo"<script>showindex=3;lightyear.notify('两次输入不匹配！', 'danger', 3000);</script>";
        } 
    } 
} 

if (isset($_POST['closesecret_key'])) {
    $db->mSet("iptv_config", "value=NULL", "where name='secret_key'");
    echo"<script>showindex=3;lightyear.notify('安全码验证已关闭！', 'success', 3000);</script>";
} 
// 添加管理员操作
if (isset($_POST['adminadd'])) {
    if (empty($_POST['addadminname']) || empty($_POST['addadminpsw'])) {
        echo"<script>showindex=5;lightyear.notify('管理员的账号或是密码不能为空！', 'danger', 3000);</script>";
    } else {
        $adminname = $_POST['addadminname'];
        $adminpsw = md5(PANEL_MD5_KEY . $_POST['addadminpsw']);
        if ($row = $db->mGetRow("iptv_admin", "*")) {
            if ($row[0] > 5) {
                echo"<script>showindex=5;lightyear.notify('管理员数量已达上限！', 'danger', 3000);</script>";
            } else {
                if ($db->mGetRow("iptv_admin", "*", "where name='$adminname'")) {
                    echo"<script>showindex=5;lightyear.notify('管理员[$adminname]已存在！', 'danger', 3000);</script>";
                } else {
                    $db->mInt("iptv_admin", "name,psw", "'$adminname','$adminpsw'");
                    echo"<script>showindex=5;lightyear.notify('管理员[$adminname]添加成功！', 'success', 3000);</script>";
                } 
            } 
        } 
        unset($row);
    } 
} 
// 删除账号操作
if (isset($_POST['deleteadmin'])) {
    if (empty($_POST['adminname'])) {
        echo"<script>showindex=5;lightyear.notify('请选择要删除的帐号！', 'danger', 3000);</script>";
    } else {
        foreach ($_POST['adminname'] as $name) {
            if ($name <> 'admin') {
                $db->mDel("iptv_admin", "where name='$name'");
                echo"<script>showindex=5;lightyear.notify('管理员[$name]已删除！', 'success', 3000);</script>";
            } else {
                echo"<script>showindex=5;lightyear.notify('管理员[$name]删除失败！', 'danger', 3000);</script>";
            } 
        } 
    } 
} 
// 设置管理员权限
if (isset($_POST['saveauthorinfo'])) {
    if (!empty($_POST['adminname'])) {
        $db->mSet("iptv_admin", "author=0,useradmin=0,ipcheck=0,epgadmin=0,mealsadmin=0,channeladmin=0", "where name<>'admin'");
        if (!empty($_POST['author'])) {
            foreach ($_POST['author'] as $adminname) {
                $db->mSet("iptv_admin", "author=1", "where name='$adminname'");
            } 
        } 
        if (!empty($_POST['useradmin'])) {
            foreach ($_POST['useradmin'] as $adminname) {
                $db->mSet("iptv_admin", "useradmin=1", "where name='$adminname'");
            } 
        } 
        if (!empty($_POST['ipcheck'])) {
            foreach ($_POST['ipcheck'] as $adminname) {
                $db->mSet("iptv_admin", "ipcheck=1", "where name='$adminname'");
            } 
        } 
        if (!empty($_POST['epgadmin'])) {
            foreach ($_POST['epgadmin'] as $adminname) {
                $db->mSet("iptv_admin", "epgadmin=1", "where name='$adminname'");
            } 
        } 
        if (!empty($_POST['mealsadmin'])) {
            foreach ($_POST['mealsadmin'] as $adminname) {
                $db->mSet("iptv_admin", "mealsadmin=1", "where name='$adminname'");
            } 
        } 
        if (!empty($_POST['channeladmin'])) {
            foreach ($_POST['channeladmin'] as $adminname) {
                $db->mSet("iptv_admin", "channeladmin=1", "where name='$adminname'");
            } 
        } 
        echo"<script>showindex=5;lightyear.notify('管理员权限设定已保存！', 'success', 3000);</script>";
    } else {
        echo"<script>showindex=5;lightyear.notify('请选择管理员！', 'danger', 3000);</script>";
    } 
} 
// 设置APP升级信息
if (isset($_POST['submit']) && isset($_POST['appver'])) {
    $versionname = $_POST['appver'];
    $appurl = $_POST['appurl'];
    $up_size = $_POST["up_size"];
    $up_text = $_POST["up_text"];
    if (isset($_POST['up_sets'])) {
        $up_sets = 1;
    } else {
        $up_sets = 0;
    } 
	$db->mSet("iptv_config", "value='$versionname'", "where name='appver'");
	$db->mSet("iptv_config", "value='$appurl'", "where name='appurl'");
	$db->mSet("iptv_config", "value='$up_size'", "where name='up_size'");
	$db->mSet("iptv_config", "value='$up_sets'", "where name='up_sets'");
	$db->mSet("iptv_config", "value='$up_text'", "where name='up_text'");
    echo"<script>showindex=4;lightyear.notify('通用版APP升级设置成功！', 'success', 3000);</script>";
} 
// 设置APP升级信息
if (isset($_POST['submit']) && isset($_POST['appver_sdk14'])) {
    $versionname = $_POST['appver_sdk14'];
    $appurl = $_POST['appurl_sdk14'];
	$db->mSet("iptv_config", "value='$versionname'", "where name='appver_sdk14'");
	$db->mSet("iptv_config", "value='$appurl'", "where name='appurl_sdk14'");
    echo"<script>showindex=4;lightyear.notify('盒子版APP升级设置成功！', 'success', 3000);</script>";
} 

if (isset($_POST['decodersel']) && isset($_POST['buffTimeOut'])) {
    $decoder = $_POST['decodersel'];
    $buffTimeOut = $_POST['buffTimeOut'];
    $trialdays = $_POST['trialdays'];
    if ($trialdays == 0) {
        $db->mSet("iptv_users", "exp=0", "where status=-1");
    } 
	$db->mSet("iptv_config", "value='$decoder'", "where name='decoder'");
	$db->mSet("iptv_config", "value='$trialdays'", "where name='trialdays'");
	$db->mSet("iptv_config", "value='$buffTimeOut'", "where name='buffTimeOut'");
    echo"<script>showindex=4;lightyear.notify('设置成功！', 'success', 3000);</script>";
} 

if (isset($_POST['submitsetver'])) {
	$db->mSet("iptv_config", "value=value+1", "where name='setver'");
    echo"<script>showindex=4;lightyear.notify('推送成功，用户下次启动将恢复默认设置！', 'success', 3000);</script>";
} 

if (isset($_POST['submittipset'])) {
    $tiploading = $_POST['tiploading'];
    $tipusernoreg = $_POST['tipusernoreg'];
    $tipuserexpired = $_POST['tipuserexpired'];
    $tipuserforbidden = $_POST['tipuserforbidden'];
	$db->mSet("iptv_config", "value='$tiploading'", "where name='tiploading'");
	$db->mSet("iptv_config", "value='$tipusernoreg'", "where name='tipusernoreg'");
	$db->mSet("iptv_config", "value='$tipuserexpired'", "where name='tipuserexpired'");
	$db->mSet("iptv_config", "value='$tipuserforbidden'", "where name='tipuserforbidden'");
    echo"<script>showindex=4;lightyear.notify('提示信息已修改！', 'success', 3000);</script>";
} 

if (isset($_POST['weaapi_id']) && isset($_POST['weaapi_key'])) {
    $weaapi_id = $_POST['weaapi_id'];
    $weaapi_key = $_POST['weaapi_key'];
    if (empty($weaapi_id)) {
        echo("<script>showindex=0;lightyear.notify('请填写天气APP_ID！', 'danger', 3000);</script>");
    } else if (empty($weaapi_key)) {
        echo("<script>showindex=0;lightyear.notify('请填写天气APP_KEY！', 'danger', 3000);</script>");
    } else {
        if (isset($_POST['showwea'])) {
            $showwea = 1;
        } else {
            $showwea = 0;
        } 
        $db->mSet("iptv_config", "value='$showwea'", "where name='showwea'");
        $db->mSet("iptv_config", "value='$weaapi_id'", "where name='weaapi_id'");
        $db->mSet("iptv_config", "value='$weaapi_key'", "where name='weaapi_key'");
        if ($showwea == 0) {
            echo"<script>showindex=0;lightyear.notify('天气显示已关闭！', 'success', 3000);</script>";
        } else {
            echo"<script>showindex=0;lightyear.notify('天气显示已开启！', 'success', 3000);</script>";
        } 
    } 
} 

if (isset($_POST['submit']) && isset($_POST['adtext'])) {
    $adtext = $_POST['adtext'];
    $showtime = $_POST['showtime'];
    $showinterval = $_POST['showinterval'];
    $adinfo = $_POST['adinfo'];
	$db->mSet("iptv_config", "value='$adinfo'", "where name='adinfo'");
	$db->mSet("iptv_config", "value='$adtext'", "where name='adtext'");
	$db->mSet("iptv_config", "value='$showtime'", "where name='showtime'");
	$db->mSet("iptv_config", "value='$showinterval'", "where name='showinterval'");
    echo"<script>showindex=0;lightyear.notify('公告修改成功！', 'success', 3000);</script>";
} 

if (isset($_POST['submitappinfo'])) {
    $app_sign = isset($_POST['app_sign']) ? intval($_POST['app_sign']) : 10000;
    if ($app_sign < 10000 || $app_sign > 65535) {
        $app_sign = 10000;
    }
    $app_appname = $_POST['app_appname'];
    $app_packagename = $_POST['app_packagename'];
    $db->mSet("iptv_config", "value='$app_sign'", "where name='app_sign'");
    $db->mSet("iptv_config", "value='$app_appname'", "where name='app_appname'");
    $db->mSet("iptv_config", "value='$app_packagename'", "where name='app_packagename'");
    exec("nohup rebuild.sh > /tmp/rebuild.log 2>&1 &");
    echo"<script>showindex=4;lightyear.notify('保存成功！APK编译中，请稍后刷新查看！', 'success', 3000);</script>";
} 

if (isset($_POST['alipay_set'])) {
    $alipay_appid = $_POST['alipay_appid'];
    $alipay_publickey = $_POST['alipay_publickey'];
    $alipay_privatekey = $_POST['alipay_privatekey'];
	$db->mSet("iptv_config", "value='$alipay_appid'", "where name='alipay_appid'");
	$db->mSet("iptv_config", "value='$alipay_publickey'", "where name='alipay_publickey'");
	$db->mSet("iptv_config", "value='$alipay_privatekey'", "where name='alipay_privatekey'");
    echo"<script>showindex=0;lightyear.notify('提交修改成功！', 'success', 3000);</script>";
} 

// 上传 APP 背景图片
if (isset($_POST['submitsplash'])) {
    if (!isset($_FILES['splash']) || $_FILES['splash']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>showindex=1;lightyear.notify('上传失败，请重试！', 'danger', 3000);</script>";
        exit;
    }

    // 限制大小（800KB）
    if ($_FILES["splash"]["size"] > 800 * 1024) {
        echo "<script>showindex=1;lightyear.notify('图片超过800KB！', 'danger', 3000);</script>";
        exit;
    }

    // 验证文件类型（使用 getimagesize 更可靠）
    $info = getimagesize($_FILES["splash"]["tmp_name"]);
    if ($info === false || $info['mime'] !== 'image/png') {
        echo "<script>showindex=1;lightyear.notify('仅支持PNG格式！', 'danger', 3000);</script>";
        exit;
    }

    // 生成唯一文件名（避免覆盖）
    $ext = "png";
    $saveDir = "../images/";
    if (!is_dir($saveDir)) {
        mkdir($saveDir, 0755, true);
    }
    $saveName = uniqid("splash_", true) . "." . $ext;
    $savePath = $saveDir . $saveName;

    if (move_uploaded_file($_FILES["splash"]["tmp_name"], $savePath)) {
        // 构造 URL
        $protocol = (
            (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ||
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
            (isset($_SERVER['HTTP_FRONT_END_HTTPS']) && $_SERVER['HTTP_FRONT_END_HTTPS'] === 'on')
        ) ? 'https://' : 'http://';

        $url = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER["SCRIPT_NAME"]);
        $splashurl = $url . "/images/" . $saveName;

        echo "<script>showindex=1;lightyear.notify('上传成功！', 'success', 3000);</script>";
    } else {
        echo "<script>showindex=1;lightyear.notify('上传失败，无法保存文件！', 'danger', 3000);</script>";
    }
}

// 删除背景图片
if (isset($_POST['submitdelbg'])) {
    if (!isset($_POST['file'])) {
        echo "<script>showindex=1;lightyear.notify('未指定文件！', 'danger', 3000);</script>";
        exit;
    }

    // 防止目录穿越攻击
    $file = basename($_POST['file']);
    $path = "../images/" . $file;

    if (file_exists($path) && is_file($path)) {
        unlink($path);
        echo "<script>showindex=1;lightyear.notify('删除成功！', 'success', 3000);</script>";
    } else {
        echo "<script>showindex=1;lightyear.notify('文件不存在！', 'danger', 3000);</script>";
    }
}

// 上传 APP 图标图片
if (isset($_POST['submitcon'])) {
    if (!isset($_FILES['splash']) || $_FILES['splash']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>showindex=1;lightyear.notify('上传失败，请重试！', 'danger', 3000);</script>";
        exit;
    }

    // 限制大小（800KB）
    if ($_FILES["splash"]["size"] > 10 * 1024) {
        echo "<script>showindex=1;lightyear.notify('图片超过10KB！', 'danger', 3000);</script>";
        exit;
    }

    // 验证文件类型（使用 getimagesize 更可靠）
    $info = getimagesize($_FILES["splash"]["tmp_name"]);
    if ($info === false || $info['mime'] !== 'image/png') {
        echo "<script>showindex=1;lightyear.notify('仅支持PNG格式！', 'danger', 3000);</script>";
        exit;
    }

    // 生成唯一文件名（避免覆盖）
    $saveDir = "../icon/";
    if (!is_dir($saveDir)) {
        mkdir($saveDir, 0755, true);
    }
    $saveName = "icon.png";
    $savePath = $saveDir . $saveName;
    if (file_exists($savePath)) {
        unlink($savePath);
    }

    if (move_uploaded_file($_FILES["splash"]["tmp_name"], $savePath)) {
        // 构造 URL
        $protocol = (
            (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ||
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
            (isset($_SERVER['HTTP_FRONT_END_HTTPS']) && $_SERVER['HTTP_FRONT_END_HTTPS'] === 'on')
        ) ? 'https://' : 'http://';

        $url = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER["SCRIPT_NAME"]);
        $splashurl = $url . "/icon/" . $saveName;

        echo "<script>showindex=1;lightyear.notify('上传成功！重新编译APK后生效', 'success', 3000);</script>";
    } else {
        echo "<script>showindex=1;lightyear.notify('上传失败，无法保存文件！', 'danger', 3000);</script>";
    }
}

// 删除图标图片
if (isset($_POST['submitdelicon'])) {
    $file = "icon.png";
    $path = "../icon/" . $file;

    if (file_exists($path) && is_file($path)) {
        unlink($path);
        echo "<script>showindex=1;lightyear.notify('删除成功！', 'success', 3000);</script>";
    } else {
        echo "<script>showindex=1;lightyear.notify('文件不存在！', 'danger', 3000);</script>";
    }
}


if (isset($_POST['submitauthor'])) {
    $needauthor = $_POST['needauthor'];
    if ($needauthor == 1) {
        $needauthor = 0;
        echo"<script>showindex=4;lightyear.notify('用户授权已关闭！', 'success', 3000);</script>";
    } else {
        $needauthor = 1;
        echo"<script>showindex=4;lightyear.notify('用户授权已开启！', 'success', 3000);</script>";
    } 
    $db->mSet("iptv_config", "value='$needauthor'", "where name='needauthor'");
} 

if (isset($_POST['clearlog'])) {
    $db->mDel("iptv_adminrec");
    echo"<script>showindex=2;lightyear.notify('后台记录已清空！', 'success', 3000);</script>";
} 

if (isset($_POST['ipchk'])) {
    $ipchk = $_POST['ipchk'];
    $db->mSet("iptv_config", "value='$ipchk'", "where name='ipchk'");
    echo"<script>showindex=2;lightyear.notify('IP数据库已更换！', 'success', 3000);</script>";
} 
// 创建目录
$imgdir = "../images";
if (! is_dir ($imgdir)) {
    @mkdir ($imgdir, 0755, true) or die ('创建文件夹失败');
} 
$files = glob("../images/*.png");
$icon_files = glob("../icon/*.png");
// 初始化变量
$adinfo = $db->mGet("iptv_config", "value", "where name='adinfo'");
$adtext = $db->mGet("iptv_config", "value", "where name='adtext'");
$dataver = $db->mGet("iptv_config", "value", "where name='dataver'");
$appver = $db->mGet("iptv_config", "value", "where name='appver'");
$appver_sdk14 = $db->mGet("iptv_config", "value", "where name='appver_sdk14'");
$setver = $db->mGet("iptv_config", "value", "where name='setver'");
$dataurl = $db->mGet("iptv_config", "value", "where name='dataurl'");
$appurl = $db->mGet("iptv_config", "value", "where name='appurl'");
$appurl_sdk14 = $db->mGet("iptv_config", "value", "where name='appurl_sdk14'");
$showtime = $db->mGet("iptv_config", "value", "where name='showtime'");
$showinterval = $db->mGet("iptv_config", "value", "where name='showinterval'");
$splash = $db->mGet("iptv_config", "value", "where name='splash'");
$needauthor = $db->mGet("iptv_config", "value", "where name='needauthor'");
$decoder = $db->mGet("iptv_config", "value", "where name='decoder'");
$buffTimeOut = $db->mGet("iptv_config", "value", "where name='buffTimeOut'");
$tiploading = $db->mGet("iptv_config", "value", "where name='tiploading'");
$tipusernoreg = $db->mGet("iptv_config", "value", "where name='tipusernoreg'");
$tipuserexpired = $db->mGet("iptv_config", "value", "where name='tipuserexpired'");
$tipuserforbidden = $db->mGet("iptv_config", "value", "where name='tipuserforbidden'");
$trialdays = $db->mGet("iptv_config", "value", "where name='trialdays'");
$up_size = $db->mGet("iptv_config", "value", "where name='up_size'");
$up_sets = $db->mGet("iptv_config", "value", "where name='up_sets'");
$up_text = $db->mGet("iptv_config", "value", "where name='up_text'");
$secret_key = $db->mGet("iptv_config", "value", "where name='secret_key'");
$weaapi_id = $db->mGet("iptv_config", "value", "where name='weaapi_id'");
$weaapi_key = $db->mGet("iptv_config", "value", "where name='weaapi_key'");
$app_sign = $db->mGet("iptv_config", "value", "where name='app_sign'");
$app_appname = $db->mGet("iptv_config", "value", "where name='app_appname'");
$app_packagename = $db->mGet("iptv_config", "value", "where name='app_packagename'");
$alipay_appid = $db->mGet("iptv_config", "value", "where name='alipay_appid'");
$alipay_publickey = $db->mGet("iptv_config", "value", "where name='alipay_publickey'");
$alipay_privatekey = $db->mGet("iptv_config", "value", "where name='alipay_privatekey'");
$ipchk = $db->mGet("iptv_config", "value", "where name='ipchk'");
$showwea = $db->mGet("iptv_config", "value", "where name='showwea'");

?>
