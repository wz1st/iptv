<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header"><h4>管理员设定</h4></div>
			<div class="tab-content">
				<div class="tab-pane active">
					<div class="form-group">
						<form method="POST" style="padding: 20px">
							<table class="table table-hover">
								<thead>
									<tr>
										<th></th>
										<th>用户名</th>
										<th>识别授权</th>
										<th>用户管理</th>
										<th>异常检测</th>
										<th>EPG管理</th>
										<th>套餐管理</th>
										<th>频道管理</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$result=$db->mQuery("select name,author,useradmin,ipcheck,epgadmin,mealsadmin,channeladmin from iptv_admin");
									while ($row=mysqli_fetch_array($result)) {
										$adminname=$row['name'];
										$author=$row['author'];
										$useradmin=$row['useradmin'];
										$ipcheck=$row['ipcheck'];
										$epgadmin=$row['epgadmin'];
										$mealsadmin=$row['mealsadmin'];
										$channeladmin=$row['channeladmin'];
										if($author==1){
											$authorchecked=" checked='true'";
										}else{
											$authorchecked="";
										}
										if($useradmin==1){
											$useradminchecked=" checked='true'";
										}else{
											$useradminchecked="";
										}
										if($ipcheck==1){
											$ipcheckchecked=" checked='true'";
										}else{
											$ipcheckchecked="";
										}
										if($epgadmin==1){
											$epgadminchecked=" checked='true'";
										}else{
											$epgadminchecked="";
										}
										if($mealsadmin==1){
											$mealsadminchecked=" checked='true'";
										}else{
											$mealsadminchecked="";
										}
										if($channeladmin==1){
											$channeladminchecked=" checked='true'";
										}else{
											$channeladminchecked="";
										}
										if($adminname == 'admin'){
											echo "<tr>
												<td><label><i class=\"mdi mdi-block-helper\"></i></label></td>
												<td>admin</td>
												<td><input type='checkbox' checked='true' disabled='true'></td>
												<td><input type='checkbox' checked='true' disabled='true'></td>
												<td><input type='checkbox' checked='true' disabled='true'></td>
												<td><input type='checkbox' checked='true' disabled='true'></td>
												<td><input type='checkbox' checked='true' disabled='true'></td>
												<td><input type='checkbox' checked='true' disabled='true'></td>
											</tr>";
										}else{
											echo "<tr>
												<td><input value='$adminname' name='adminname[]' type='checkbox'></td>
												<td>$adminname</td>
												<td><input value='$adminname' name='author[]' type='checkbox' $authorchecked ></td>
												<td><input value='$adminname' name='useradmin[]' type='checkbox' $useradminchecked ></td>
												<td><input value='$adminname' name='ipcheck[]' type='checkbox' $ipcheckchecked ></td>
												<td><input value='$adminname' name='epgadmin[]' type='checkbox' $epgadminchecked ></td>
												<td><input value='$adminname' name='mealsadmin[]' type='checkbox' $mealsadminchecked ></td>
												<td><input value='$adminname' name='channeladmin[]' type='checkbox' $channeladminchecked ></td>
											</tr>";
										}
									}
									unset($row);
									mysqli_free_result($result);
									?>
								</tbody>
							</table>
							<button class="btn btn-label btn-primary" type="submit" name="saveauthorinfo"><label><i class="mdi mdi-checkbox-marked-circle-outline"></i></label>保存权限设定</button>
							<button class="btn btn-label btn-danger" type="submit" name="deleteadmin"><label><i class="mdi mdi-delete-empty"></i></label>删除选中</button>
						</form>
						<form class="form-inline" method="post">
							<div class="form-group">
								<label class="sr-only">用户名</label>
								<input class="form-control" type="text" name="addadminname" placeholder="请输入用户名..">
							</div>
							<div class="form-group">
								<label class="sr-only">密码</label>
								<input class="form-control" type="password" id="example-if-password" name="addadminpsw" placeholder="请输入密码..">
							</div>
							<div class="form-group">
								<button class="btn btn-label btn-primary" type="submit" name="adminadd" ><label><i class="mdi mdi-key-plus"></i></label>增加管理员</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="card">
			<div class="card-header"><h4>修改管理员密码</h4></div>
			<div class="card-body">
				<form method="post">
					<div class="example-box">
					<label class="btn-block">用户名</label>
						<input class="form-control" type="text" name="username" value="admin" size="80"><br>
					<label class="btn-block">旧密码</label>
						<input class="form-control" type="password" name="oldpassword" value="" size="80"><br>
					<label class="btn-block">新密码</label>
						<input class="form-control" type="password" name="newpassword" value="" size="80"><br>
					</div>
					<button class="btn btn-label btn-primary" type="submit" name="submit" value=""><label><i class="mdi mdi-checkbox-marked-circle-outline"></i></label>修改密码</button>
				</form>
			</div>
		</div>
	</div>
</div>