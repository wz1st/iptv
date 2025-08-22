<?php require_once "views/view.main.php";require_once "apps/alipayController.php";?>
<script type="text/javascript" src="views/js/wxcheck.js"></script>
<body scroll="no" style="overflow-x:hidden;overflow-y:hidden">
	<div id="container" class="row lyear-wrapper">
		<div class="lyear-login">
			<div id="bg">
				<div id="anitOut"></div>
			</div>
			<div class="login-center form__content">
				<div class="login-header text-center">
					<a href="payment.php"> <img src="views/images/logo-sidebar.png"> </a>
				</div>
				<table class="table form-inline">
					<?php
						if (isset($_POST['dopay'])) {
							if ($result['code'] && $result['code']=='10000') {
							    //生成二维码
							    $url = $result['qr_code'];
							    $qr_code = 'http://qr.topscan.com/api.php?text=' . $url . '&bg=ffffff&fg=000000&pt=1c73bd&m=10&w=400&el=1&inpt=1eabfc&logo=https://t.alipayobjects.com/tfscom/T1Z5XfXdxmXXXXXXXX.png';
							    exit ("
										<tr>
											<td>
												<img class='w-75 m-b-10' src='{$qr_code}' />
												<form method='GET'>
													<div class='form-group'>
														<button type='button' class='btn btn-block btn-primary' onclick='jumptoalipay();'>前往支付宝</button>
													</div>
													<div class='form-group'>
														<button type='submit' class='btn btn-block btn-primary' name='checkpay' value='$userid'>我已支付</button>
													</div>
												</form>
											</td>
										</tr>
										<script>
											function jumptoalipay() {
												var gotoUrl = '$url';
												_AP.pay(gotoUrl);
											}
										</script>
									");
							} else {
							    exit ("
										<tr>
											<td>
												订单生成失败，请联系管理员。
											<td>
										<tr>
								");
							}
						}
						
						if (isset($_GET['checkpay'])) {
							$checkpay = $_GET['checkpay'];
						    if($db->mGet("iptv_meals", "status", "where userid=$checkpay") == 1){
								exit ("<script>$.alert({title: '支付成功',content: '订单已支付成功，请重新启动APP！',type: 'green',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){window.location.href='payment.php';}}}});</script>");
						    } else {
								exit ("<script>$.alert({title: '支付失败',content: '支付状态为未支付，如果您已支付，请联系管理员！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){window.location.href='payment.php';}}}});</script>");
						    }
						}
					?>
					<?php 						
					if (isset($_POST['userid_enter'])) {
						$userid=$_POST['userid'];
						if ($row = $db->mCheckRow("iptv_users", "name,mac,ip,region", "where name='$userid'")) {
						    $userid= $row['name'];
						    $usermac= $row['mac'];
						    $userip= $row['ip'];
						    $userloc= $row['region'];
						} else {
							exit ("<script>$.alert({title: '警告',content: '找不到该用户，请确认用户ID是否正确！',type: 'orange',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){window.location.href='payment.php';}}}});</script>");
						}
						echo "
							<label>请确认订单信息</label>
							<tr align='left'><td>用户ID：$userid</td></tr>
							<tr align='left'><td>用户IP：$userip</td></tr>
							<tr align='left'><td>用户位置：$userloc</td></tr>
							<tr align='left'><td>设备MAC地址：$usermac</td></tr>
						";
						echo '
						<form class="form-inline" id="order_form" method="post">
							<tr align="left" class="m-t-15">
								<td>
									<div class="input-group">
										<span>购买套餐：</span>
										<input type="hidden" name="userid" value="'. $userid .'"/>
										<select class="btn btn-sm btn-default dropdown-toggle" style="height: 30px;" name="mealid">
											<option value="">请选择</option>';
											$result=$db->mQuery("select id,name from iptv_meals where status=1 and id<>1000 ORDER BY id ASC");
											while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
												echo '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
											} 
											mysqli_free_result($result);
						echo			'</select>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form-group w-100">
										<button type="submit" class="btn btn-block btn-primary" name="dopay" id="dopay">提交订单</button>
									</div>
								</td>
							</tr>
						</form>
						';
						echo '<script type="text/javascript">$("#userid_form").hide;$("#userid_form").hide(0);</script>';
					} ?>
				</table>
				<form class="form-inline" id="userid_form" method="POST">
					<div class="form-group">
						<input type="text" name="userid" class="form-control" value="<?php echo $userid ?>" placeholder="请输入用户ID">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-block btn-primary" name="userid_enter" id="userid_enter">查询</button>
					</div>
				</form>
				<hr>
				<footer class="col-sm-12 text-center">
					<p class="m-b-0">Copyright © 2020 <a href="http://www.spk.bobohome.store:8880">spk.bobohome.store:8880</a>. All right reserved</p>
				</footer>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	$('#userid_enter').on('click', function(){
	    lightyear.loading('show');
	});
	$('#dopay').on('click', function(){
	    lightyear.loading('show');
	});
	</script>
</body>