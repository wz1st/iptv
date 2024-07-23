<script type="text/javascript">
function weaForm(){
	$("#weaform").submit();
}
</script>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header"><h4>系统公告</h4></div>
			<div class="tab-content">
				<div class="tab-pane active">
					<form method="post" id="weaform" >
						<div class="form-group">
							<label>天气APP_ID</label>
							<input class="form-control" type="text" name="weaapi_id" value="<?php echo $weaapi_id ?>" placeholder="天气APP_ID" >
						</div>
						<div class="form-group">
							<small class="help-block">请先到<a href="https://tianqiapi.com" target="_blank">这里</a>注册账号</small>
							<label>天气APP_KEY</label>
							<input class="form-control" type="text" name="weaapi_key" value="<?php echo $weaapi_key ?>" placeholder="天气APP_KEY" >
						</div>
						<div class="form-group">
							<label>显示天气</label>
							<label class="lyear-switch switch-primary">
								<?php
								switch ($showwea) {
									case '0':
	    								$showweachecked = '';
										break;
									case '1':
	    								$showweachecked = 'checked="checked"';
										break;
								}
								?>
								<input type="checkbox" name="showwea" onchange="weaForm()" <?php echo $showweachecked;?>>
								<span></span>
							</label>
						</div>
					</form>

					<form method="post">
						
                    	<div class="form-group">
							<label>系统公告</label>
                    		<textarea class="form-control" rows="5" name="adtext" placeholder="请输入公告内容" ><?php echo $adtext ?></textarea>
						</div>
                    	<div class="form-group">
							<label>预留文字</label>
                    		<textarea class="form-control" rows="5" name="adinfo" placeholder="请输入文字内容" ><?php echo $adinfo;?></textarea>
						</div>
						<div class="form-group">
							<label>显示时间（秒）</label>
							<input class="form-control" type="text" name="showtime" value="<?php echo $showtime;?>" >
						</div>
						<div class="form-group">
							<label>显示间隔（分）</label>
							<input class="form-control" type="text" name="showinterval" value="<?php echo $showinterval;?>" >
						</div>
						<div class="form-group">
							<button class="btn btn-label btn-primary" type="submit" name="submit"><label><i class="mdi mdi-checkbox-marked-circle-outline"></i></label>确认提交</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>