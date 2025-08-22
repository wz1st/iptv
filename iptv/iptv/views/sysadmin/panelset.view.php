<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header"><h4>修改安全码</h4></div>
			<div class="card-body">
				<form method="post">
					<div class="form-group">
						<label class="btn-block">新安全码</label>
						<input class="form-control" type="password" name="newsecret_key" value=""><br>
						<label class="btn-block">确认新安全码</label>
						<input class="form-control" type="password" name="newsecret_key_confirm" value="">
					</div>
					<div class="form-group">
						<button class="btn btn-label btn-primary" type="submit" name="submit" value=""><label><i class="mdi mdi-checkbox-marked-circle-outline"></i></label>设置安全码</button>
						<button class="btn btn-danger" type="submit" name="closesecret_key" value="" <?php if(empty($secret_key)){echo 'disabled';} ?>><?php if (empty($secret_key)){echo '安全码验证已关闭';} else {echo '关闭安全码验证';} ?></button>
					</div>
				</form>
			</div>
		</div>
		<hr>
		<div class="card">
			<div class="card-header"><h4>支付宝接口设置</h4></div>
			<div class="card-body">
				<form method="post">
					<div class="form-group">
						<label class="btn-block">应用ID</label>
						<input class="form-control" type="text" name="alipay_appid" value="<?php echo $alipay_appid; ?>">
						<small class="help-block"><a href="https://docs.open.alipay.com/200/105310" target="_blank">应用生成教程</a></small>
						<label class="btn-block">应用私钥</label>
						<textarea class="form-control" rows="5" name="alipay_privatekey"><?php echo $alipay_privatekey; ?></textarea>
						<small class="help-block"><a href="https://docs.open.alipay.com/291/105971" target="_blank">应用私钥生成教程</a></small>
						<label class="btn-block">支付宝公钥</label>
						<textarea class="form-control" rows="4" name="alipay_publickey"><?php echo $alipay_publickey; ?></textarea>
						<small class="help-block"><a href="https://docs.open.alipay.com/291/105972" target="_blank">支付宝公钥获取教程</a></small>
					</div>
					<div class="form-group">
						<button class="btn btn-label btn-primary" type="submit" name="alipay_set" value=""><label><i class="mdi mdi-checkbox-marked-circle-outline"></i></label>提交修改</button>
					</div>
				</form>
			</div>
		</div>
		<hr>
		<div class="card">
			<div class="card-header"><h4>数据库操作</h4></div>
			<div class="card-body">
				<div class="input-group">
					<div class="input-group-btn">
						<a target="_blank" href="../apps/randkey.php" onclick="return confirm('确认更新随机秘钥吗？')"><button type="button" class="btn btn-info m-r-5">更新随机秘钥</button></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
