<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header"><h4>背景图片</h4></div>
			<div class="tab-content">
				<div class="tab-pane active">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>图片名称</th>
								<th>文件时间</th>
								<th>图片大小</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php
						foreach ($files as $file) {
							$fctime=date("Y-m-d H:i:s",filectime($file));
							$fsize=filesize($file);
                            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' || 
                                        isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ||
                                        isset($_SERVER['HTTP_FRONT_END_HTTPS']) && $_SERVER['HTTP_FRONT_END_HTTPS'] === 'on' ? 'https://' : 'http://';
							$url=$protocol.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"]; 
							$splashurl=dirname($url).'/'.$file;
							$file=basename($file);
							if($fsize>=1024){
								$fsize=round($fsize / 1024 * 100) / 100 . ' KB';
							}else{
								$fsize=$fsize ." B";
							}
							echo "
						<tr>
							<td>$file</td>
							<td>$fctime</td>
							<td>$fsize</td>
							<td>
								<form method='post'>
									<button class=\"btn btn-w-md btn-secondary\" type='button' onclick=\"javascript:window.open('$splashurl')\">预览</button>
									<input type='hidden' name='file' value='$file'>
									<button class=\"btn btn-w-md btn-danger\" type='submit' name='submitdelbg' onclick=\"return confirm('确认删除？')\" >删除</button>
								</form>
							</td>
						</tr>";
						}
						unset($files);
						?>
	                  </tbody>
	                </table>
					<small class="help-block">提示：图片仅支持PNG格式，不超过800KB，多张图片为随机显示。</small>
					<form method="post" enctype="multipart/form-data">
						<div class="form-group">
							<input type="file" name="splash" accept="image/png" />
						</div>
						<div class="form-group">
							<button id="submit" class="btn btn-w-md btn-primary" type="submit" name="submitsplash" >开始上传</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#submit').on('click', function(){
	    lightyear.loading('show');
	});
</script>