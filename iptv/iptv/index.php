<?php require_once "apps/userloginController.php";require_once "views/view.main.php"; ?>
<body scroll="no" style="overflow-x:hidden;overflow-y:hidden">
	<div id="container" class="row lyear-wrapper">
		<div class="lyear-login">
			<div id="bg">
				<div id="anitOut"></div>
			</div>
			<div class="login-center form__content">
				<div class="login-header text-center">
					<a href="index.php"> <img alt="light year admin" src="views/images/logo-sidebar.png"> </a>
				</div>
				<form id="SecretkeyForm" method="post">
					<div class="form-group has-feedback feedback-left">
						<input type="password" name="secret_key" class="form-control" placeholder="请输入安全验证码">
						<span class="mdi mdi-check-all form-control-feedback" aria-hidden="true"></span>
					</div>
					<div class="form-group has-feedback feedback-left">
						<label class="lyear-checkbox checkbox-primary pull-left m-b-10">
							<input type="checkbox" name="remembersecret_key">
							<span>记住7天</span>
						</label>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-block btn-primary" name="secret_key_enter" id="secret_key_enter">立即登陆</button>
					</div>
				</form>
				<form id="LoginForm" method="post">
					<div class="form-group has-feedback feedback-left">
						<input type="text" placeholder="请输入您的用户名" class="form-control" name="username" id="username" />
						<span class="mdi mdi-account form-control-feedback" aria-hidden="true"></span>
					</div>
					<div class="form-group has-feedback feedback-left">
						<input type="password" placeholder="请输入密码" class="form-control" id="password" name="password" />
						<span class="mdi mdi-lock form-control-feedback" aria-hidden="true"></span>
					</div>
					<div class="form-group has-feedback feedback-left">
						<label class="lyear-checkbox checkbox-primary pull-left m-b-10">
						<input type="checkbox" name="rememberpass">
							<span>记住7天</span>
						</label>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-block btn-primary" id="login_key_enter" >进入后台</button>
					</div>
				</form>
				<hr>
				<footer class="col-sm-12 text-center">
					<p class="m-b-0">&copy; 2023 群晖IPTV管理系统</p>
				</footer>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	// 消息提示示例
	$('#secret_key_enter').on('click', function(){
	    lightyear.loading('show');
	});
	$('#login_key_enter').on('click', function(){
	    lightyear.loading('show');
	});
	</script>
	<?php 
		if($_SESSION['secret_key_status']=='1'){
			echo '<script type="text/javascript">$("#SecretkeyForm").hide;$("#SecretkeyForm").hide(0);</script>';
		} else {
			echo '<script type="text/javascript">$("#LoginForm").hide;$("#LoginForm").hide(0);</script>';
		}
	?>
</body>