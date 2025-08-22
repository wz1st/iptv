<?php
//decode by w ww.mi knio.c om
require_once "../config.php";require_once "../apps/usercheck.php"; ?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=0.92, maximum-scale=1, user-scalable=no" />
<meta name="keywords" content="群晖IPTV管理系统" />
<meta name="description" content="群晖IPTV管理系统" />
<meta name="author" content="iptv" />
<meta name="renderer" content="webkit" />
<title>群晖IPTV管理系统</title>
<link rel="icon" href="images/favicon.ico" type="image/ico">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/materialdesignicons.min.css" rel="stylesheet">
<link href="css/style.min.css" rel="stylesheet">
<link href="css/animate.css" rel="stylesheet">
<link rel="stylesheet" href="js/jconfirm/jquery-confirm.min.css">
</head>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="js/main.min.js"></script>
<script type="text/javascript" src="js/lightyear.js"></script>
<script src="js/jconfirm/jquery-confirm.min.js"></script>
<script src="js/bootstrap-notify.min.js"></script>

<body>
<div class="lyear-layout-web">
	<div class="lyear-layout-container">
		<!--左侧导航-->
		<aside class="lyear-layout-sidebar">
			<!-- logo -->
			<div id="logo" class="sidebar-header">
				<a href="index.php"><img src="images/logo-sidebar.png"/></a>
			</div>
			<div class="lyear-layout-sidebar-scroll"> 
				<nav class="sidebar-main">
					<ul class="nav nav-drawer">
						<?php
						if (strpos($_SERVER['REQUEST_URI'],'index.php') !== false){
							$index='active';
						} else if (strpos($_SERVER['REQUEST_URI'],'author.php') !== false){
							$author='active';
						} else if (strpos($_SERVER['REQUEST_URI'],'useradmin.php') !== false){
							$useradmin='active';
						} else if (strpos($_SERVER['REQUEST_URI'],'exception.php') !== false){
							$exception='active';
						} else if (strpos($_SERVER['REQUEST_URI'],'mealsadmin.php') !== false){
							$mealsadmin='active';
						} else if (strpos($_SERVER['REQUEST_URI'],'epgadmin.php') !== false){
							$epgadmin='active';
						} else if (strpos($_SERVER['REQUEST_URI'],'mealsadmin.php') !== false){
							$mealsadmin='active';
						} else if (strpos($_SERVER['REQUEST_URI'],'ordersadmin.php') !== false){
							$ordersadmin='active';
						} else if (strpos($_SERVER['REQUEST_URI'],'type=default') !== false){
							$default='active';
						} else if (strpos($_SERVER['REQUEST_URI'],'type=province') !== false){
							$province='active';
						} else if (strpos($_SERVER['REQUEST_URI'],'type=chinanet') !== false){
							$chinanet='active';
						} else if (strpos($_SERVER['REQUEST_URI'],'type=unicom') !== false){
							$unicom='active';
						} else if (strpos($_SERVER['REQUEST_URI'],'type=cmcc') !== false){
							$cmcc='active';
						} else if (strpos($_SERVER['REQUEST_URI'],'type=vip') !== false){
							$vip='active';
						} else if (strpos($_SERVER['REQUEST_URI'],'index=0') !== false){
							$index0='active';
						} else if (strpos($_SERVER['REQUEST_URI'],'index=1') !== false){
							$index1='active';
						} else if (strpos($_SERVER['REQUEST_URI'],'index=2') !== false){
							$index2='active';
						} else if (strpos($_SERVER['REQUEST_URI'],'index=3') !== false){
							$index3='active';
						} else if (strpos($_SERVER['REQUEST_URI'],'index=4') !== false){
							$index4='active';
						} else if (strpos($_SERVER['REQUEST_URI'],'index=5') !== false){
							$index5='active';
						}
						?>
						<li class="nav-item <?php echo $index ?>"> <a href="index.php"><i class="mdi mdi-home"></i>首页</a> </li>
						<li class="nav-item <?php echo $author ?>"> <a href="author.php"><i class="mdi mdi-account-check"></i>授权</a> </li>
						<li class="nav-item <?php echo $useradmin ?>"> <a href="useradmin.php"><i class="mdi mdi-account"></i>用户</a> </li>
						<li class="nav-item <?php echo $exception ?>"> <a href="exception.php"><i class="mdi mdi-account-alert"></i>异常</a> </li>
						<li class="nav-item <?php echo $mealsadmin ?>"> <a href="mealsadmin.php"><i class="mdi mdi-shopping"></i>套餐</a></li>
						<li class="nav-item <?php echo $ordersadmin ?>"> <a href="ordersadmin.php"><i class="mdi mdi-wallet-giftcard"></i>订单</a></li>
						<li class="nav-item <?php echo $epgadmin ?>"> <a href="epgadmin.php"><i class="mdi mdi-television-guide"></i>EPG</a> </li>
						<li class="nav-item nav-item-has-subnav">
              <a href="movie.php"><i class="mdi mdi-language-javascript"></i>点播管理</a>
            </li>
						<li class="nav-item nav-item-has-subnav channeladmin">
							<a href="javascript:void(0)"><i class="mdi mdi-television-classic"></i>频道列表</a>
							<ul class="nav nav-subnav">
								<li class="<?php echo $default ?>"><a href="channeladmin.php?type=default">默认频道</a></li>
								<li class="<?php echo $province ?>"><a href="channeladmin.php?type=province">省份频道</a></li>
								<li class="<?php echo $chinanet ?>"><a href="channeladmin.php?type=chinanet">电信频道</a></li>
								<li class="<?php echo $unicom ?>"><a href="channeladmin.php?type=unicom">联通频道</a></li>
								<li class="<?php echo $cmcc ?>"><a href="channeladmin.php?type=cmcc">移动频道</a></li>
								<li class="<?php echo $vip ?>"><a href="channeladmin.php?type=vip">会员频道</a></li>
							</ul>
						</li>
						<li class="nav-item nav-item-has-subnav sysadmin">
							<a href="javascript:void(0)"><i class="mdi mdi-settings-box"></i>系统设置</a>
							<ul class="nav nav-subnav">
								<li class="<?php echo $index0 ?>"><a href="sysadmin.php?index=0">系统公告</a></li>
								<li class="<?php echo $index1 ?>"><a href="sysadmin.php?index=1">背景图片</a></li>
								<li class="<?php echo $index2 ?>"><a href="sysadmin.php?index=2">后台记录</a></li>		
								<li class="<?php echo $index3 ?>"><a href="sysadmin.php?index=3">后台设置</a></li>
								<li class="<?php echo $index4 ?>"><a href="sysadmin.php?index=4">客户端设置</a></li>
								<li class="<?php echo $index5 ?>"><a href="sysadmin.php?index=5">管理员设置</a></li>
							</ul>
						</li>
					</ul>
				</nav>
				
				<div class="sidebar-footer">
					<p align="center"><?php echo date("Y-m-d H:i",time()); ?></p>
					<p class="copyright">&nbsp;&nbsp;&nbsp;&copy; 2023 群晖IPTV管理系统</p>
				</div>
			</div>
		</aside>
		<!--End 左侧导航-->
		
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
						<span class="navbar-page-title">
						<?php
						if (strpos($_SERVER['REQUEST_URI'],'index.php') !== false){ echo '&nbsp;首页&nbsp;'; }
						else if (strpos($_SERVER['REQUEST_URI'],'author.php') !== false){ echo '&nbsp;授权&nbsp;'; }
						else if (strpos($_SERVER['REQUEST_URI'],'useradmin.php') !== false){ echo '&nbsp;用户&nbsp;'; }
						else if (strpos($_SERVER['REQUEST_URI'],'exception.php') !== false){ echo '&nbsp;异常&nbsp;'; }
						else if (strpos($_SERVER['REQUEST_URI'],'mealsadmin.php') !== false){ echo '&nbsp;套餐&nbsp;'; }
						else if (strpos($_SERVER['REQUEST_URI'],'ordersadmin.php') !== false){ echo '&nbsp;订单&nbsp;'; }
						else if (strpos($_SERVER['REQUEST_URI'],'epgadmin.php') !== false){ echo '&nbsp;EPG&nbsp;'; }
						else if (strpos($_SERVER['REQUEST_URI'],'channeladmin.php') !== false){ echo '&nbsp;频道列表&nbsp;'; }
						else if (strpos($_SERVER['REQUEST_URI'],'sysadmin.php') !== false){ echo '&nbsp;系统设置&nbsp;'; }
						?>
						</span>
					</div>
					<ul class="topbar-right">
						<li class="dropdown dropdown-profile">
							<a href="javascript:void(0)" data-toggle="dropdown">
								<span style="font-size: 15px;padding-right: 10px;"><?php echo $user ?></span>
								<img class="img-avatar img-avatar-32 m-r-5" src="images/users/avatar.png" alt="user" />
							</a>
							<ul class="dropdown-menu dropdown-menu-right">
								<li> <a href="../apps/logout.php"><i class="mdi mdi-logout-variant"></i> 退出登录</a> </li>
							</ul>
						</li>
						<!--切换主题配色-->
						<li class="dropdown dropdown-skin">
							<span data-toggle="dropdown" class="icon-palette"><i class="mdi mdi-palette"></i></span>
							<ul class="dropdown-menu dropdown-menu-right" data-stopPropagation="true">
								<li class="drop-title"><p>主题</p></li>
								<li class="drop-skin-li clearfix">
									<span class="inverse">
										<input type="radio" name="site_theme" value="default" id="site_theme_1">
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
										<input type="radio" name="logo_bg" value="default" id="logo_bg_1">
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
										<input type="radio" name="header_bg" value="default" id="header_bg_1">
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
										<input type="radio" name="sidebar_bg" value="default" id="sidebar_bg_1">
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
					</ul>
				</div>
			</nav>
		</header>
		<!--End 头部信息-->