<meta charset="UTF-8"> <!-- for HTML5 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>清和影视</title>
<link rel="icon" href="favicon.ico" type="image/ico">
 <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<meta name="keywords" content="清和影视">
<meta name="description" content="清和影视">
<meta name="author" content="yinqi">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/materialdesignicons.min.css" rel="stylesheet">
<link href="css/style.min.css" rel="stylesheet">

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="js/main.min.js"></script>


<!-- 固定表头所需的js和css(bootstrap-table) -->
<link rel="stylesheet" type="text/css" href="./css/bootstrap-table.min.css">
<script src="./js/bootstrap-table.min.js"></script>
<!-- 固定列所需的js和css(bootstrap-table-fixed-columns) -->
<link rel="stylesheet" type="text/css" href="./css/bootstrap-table-fixed-columns.css">
<script src="./js/bootstrap-table-fixed-columns.js"></script>
<title>清和影视</title>
<?php
include_once "conn.php";
include_once "val.php";

?>
<style type="text/css">

a:link, a:visited { text-decoration: none; color: #000 }
#topnav { width: 100%; background: #33a996; height: 50px; line-height: 50px; }
#topnav ul { width: 100%; margin: auto }
#topnav a { display: inline-block; font-size: 18px; font-family: "Microsoft Yahei", Arial, Helvetica, sans-serif; padding: 0 20px; }
#topnav a:hover { background: #345; color: #fff; border-top: 0px solid #f77825; }
#topnav a { color: #FFF }
#topnav_current { background: #345; border-top: 0px solid #f77825; color: #fff }/* 高亮选中颜色 */
a#topnav_current { color: #fff }
</style>



    <!--头部信息-->
    <header class="lyear-layout-header">
      
      <nav class="navbar navbar-default">
        <div class="topbar">
          
          <div class="topbar-left">
            <div class="lyear-aside-toggler">
              <span class="lyear-toggler-bar"></span>
              <span class="lyear-toggler-bar"></span>
              <span class="lyear-toggler-bar"></span>
            </div>
            <span class="navbar-page-title"> 后台首页 </span>
             <?php date_default_timezone_set('Etc/GMT-8');echo date("H:i",time()); ?>
          </div>
          
          <ul class="topbar-right">
            <li class="dropdown dropdown-profile">
              <a href="javascript:void(0)" data-toggle="dropdown">
                <img class="img-avatar img-avatar-48 m-r-10" src="images/user.jpg" alt="" />
                <span><?php echo "管理员：【".$user . "】" ?> <span class="caret"></span></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-right">
                <!-- <li> <a href="lyear_pages_profile.html"><i class="mdi mdi-account"></i> 个人信息</a> </li> -->
                <!-- <li> <a href="lyear_pages_edit_pwd.html"><i class="mdi mdi-lock-outline"></i> 修改密码</a> </li> -->
                
                <li> <a href="madmin.php"><i class="mdi mdi-delete"></i> 丑陋版</a></li>
                <li> <a href="javascript:void(0)"><i class="mdi mdi-delete"></i> 清空缓存</a></li>
                <li class="divider"></li>
                <li> <a href="logout.php"><i class="mdi mdi-logout-variant"></i> 退出登录</a> </li>
              </ul>
            </li>
            <!--切换主题配色-->
        <li class="dropdown dropdown-skin">
        <span data-toggle="dropdown" class="icon-palette"><i class="mdi mdi-palette"></i></span>
        <ul class="dropdown-menu dropdown-menu-right" data-stopPropagation="true">
                <li class="drop-title"><p>主题</p></li>
                <li class="drop-skin-li clearfix">
                  <span class="inverse">
                    <input type="radio" name="site_theme" value="default" id="site_theme_1" checked>
                    <label for="site_theme_1"></label>
                  </span>
                  <span>
                    <input type="radio" name="site_theme" value="dark" id="site_theme_2">
                    <label for="site_theme_2"></label>
                  </span>
                  <span>
                    <input type="radio" name="site_theme" value="translucent" id="site_theme_3">
                    <label for="site_theme_3"></label>
                  </span>
                </li>
          <li class="drop-title"><p>LOGO</p></li>
        <li class="drop-skin-li clearfix">
                  <span class="inverse">
                    <input type="radio" name="logo_bg" value="default" id="logo_bg_1" checked>
                    <label for="logo_bg_1"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_2" id="logo_bg_2">
                    <label for="logo_bg_2"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_3" id="logo_bg_3">
                    <label for="logo_bg_3"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_4" id="logo_bg_4">
                    <label for="logo_bg_4"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_5" id="logo_bg_5">
                    <label for="logo_bg_5"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_6" id="logo_bg_6">
                    <label for="logo_bg_6"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_7" id="logo_bg_7">
                    <label for="logo_bg_7"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_8" id="logo_bg_8">
                    <label for="logo_bg_8"></label>
                  </span>
        </li>
        <li class="drop-title"><p>头部</p></li>
        <li class="drop-skin-li clearfix">
                  <span class="inverse">
                    <input type="radio" name="header_bg" value="default" id="header_bg_1" checked>
                    <label for="header_bg_1"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_2" id="header_bg_2">
                    <label for="header_bg_2"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_3" id="header_bg_3">
                    <label for="header_bg_3"></label>
                  </span>
                  <span>
                    <input type="radio" name="header_bg" value="color_4" id="header_bg_4">
                    <label for="header_bg_4"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_5" id="header_bg_5">
                    <label for="header_bg_5"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_6" id="header_bg_6">
                    <label for="header_bg_6"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_7" id="header_bg_7">
                    <label for="header_bg_7"></label>
                  </span>
                  <span>
                    <input type="radio" name="header_bg" value="color_8" id="header_bg_8">
                    <label for="header_bg_8"></label>
                  </span>
        </li>
        <li class="drop-title"><p>侧边栏</p></li>
        <li class="drop-skin-li clearfix">
                  <span class="inverse">
                    <input type="radio" name="sidebar_bg" value="default" id="sidebar_bg_1" checked>
                    <label for="sidebar_bg_1"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_2" id="sidebar_bg_2">
                    <label for="sidebar_bg_2"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_3" id="sidebar_bg_3">
                    <label for="sidebar_bg_3"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_4" id="sidebar_bg_4">
                    <label for="sidebar_bg_4"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_5" id="sidebar_bg_5">
                    <label for="sidebar_bg_5"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_6" id="sidebar_bg_6">
                    <label for="sidebar_bg_6"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_7" id="sidebar_bg_7">
                    <label for="sidebar_bg_7"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_8" id="sidebar_bg_8">
                    <label for="sidebar_bg_8"></label>
                  </span>
        </li>
        </ul>
      </li>
            <!--切换主题配色-->
          </ul>
          
        </div>
      </nav>
      
    </header>
    <!--End 头部信息-->

  <!--左侧导航-->
    <aside class="lyear-layout-sidebar">
      
      <!-- logo -->
      <div id="logo" class="sidebar-header">
        <a href="sysadmin.php"><img src="images/logo_left.jpg" title="LightYear" alt="LightYear" /></a>
      </div>
      <div class="lyear-layout-sidebar-scroll"> 
        
        <nav class="sidebar-main">
          <ul class="nav nav-drawer">
            <li class="nav-item active"> <a href="sysadmin.php"><i class="mdi mdi-home"></i> EZ后台</a> </li>
            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-palette"></i> 系统管理</a>
              <ul class="nav nav-subnav">
                <li> <a href="sysadmin.php">系统</a> </li>
                <li> <a href="ipcheck.php">异常</a> </li>
                <li> <a href="#">-----------------------</a> </li>
                <li><a href="#" onclick="showli(0)">系统公告</a></li>
                <li><a href="#" onclick="showli(1)">系统备份</a></li>
                <li><a href="#" onclick="showli(2)">APP设置</a></li>
                <li><a href="#" onclick="showli(3)">背景图片</a></li>   
                <li><a href="#" onclick="showli(4)">修改密码</a></li>
                <li id='adminset'><a href="#" onclick="showli(5)">管理员设置</a></li>
                <li><a href="#" onclick="showli(6)">免责声明</a></li>
              </ul>
            </li>
            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-format-align-justify"></i> 用户管理</a>
              <ul class="nav nav-subnav">
                <li> <a href="useradmin0.php">授权</a> </li>
                <li> <a href="useradmin1.php">账号</a> </li>
                <li> <a href="useradmin2.php">用户</a> </li>
                <li> <a href="meals.php">套餐</a> </li>
              </ul>
            </li>
            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-file-outline"></i> 视频管理</a>
              <ul class="nav nav-subnav">
                <li> <a href="channeladmin.php?nettype=全网">全网</a> </li>
                <li> <a href="channeladmin.php?nettype=通用">通用</a> </li>
                <li> <a href="channeladmin.php?nettype=省内">省内</a> </li>
                <li> <a href="channeladmin.php?nettype=电信">电信</a> </li>
                <li> <a href="channeladmin.php?nettype=移动">移动</a> </li>
                <li> <a href="channeladmin.php?nettype=联通">联通</a> </li>
                <li> <a href="channeladmin.php?nettype=隐藏">隐藏</a> </li>
              </ul>
            </li>
            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-language-javascript"></i>EPG管理</a>
              <ul class="nav nav-subnav">
                <li> <a href="epg.php">EPG列表</a> </li>
              </ul>
            </li>

            <li class="nav-item nav-item-has-subnav">
              <a href="movie.php"><i class="mdi mdi-language-javascript"></i>点播管理</a>
            </li>
           
          </ul>
        </nav>
        
        <div class="sidebar-footer">
          
        </div>
      </div>
      
    </aside>
    <!--End 左侧导航-->






<?php
error_reporting(0); 
//创建境外表
mysqli_query($con,"CREATE TABLE IF NOT EXISTS `chzb_category_jw` (
  `id` int(11) NOT NULL,
  `name` varchar(16) NOT NULL,
  `isprov` tinyint(4) NOT NULL DEFAULT '0',
  `canseek` tinyint(4) NOT NULL DEFAULT '0',
  `enable` tinyint(4) NOT NULL DEFAULT '1',
  `updateurl` varchar(500) DEFAULT '',
  `psw` varchar(16) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
?>
