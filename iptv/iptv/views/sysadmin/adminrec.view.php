<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header"><h4>后台记录</h4></div>
			<form align="center" style="padding: 5px;" method="POST" >
				<button type="submit" name="clearlog" class="btn btn-label btn-danger"><label><i class="mdi mdi-delete-empty"></i></label> 清空记录</button>
			</form>
			<div class="tab-content">
				<div class="tab-pane active">
					<div class="form-group">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>账号</th>
										<th>登入IP</th>
										<th>登入位置</th>
										<th>登入时间</th>
										<th>操作</th>
										<th width="40px">
										</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$result=$db->mQuery("SELECT name,ip,loc,time,func from iptv_adminrec order by time desc");
									while ($row=mysqli_fetch_array($result)) {
										$loguser=$row['name'];
										$logip=$row['ip'];
										$logloc=$row['loc'];
										$logtime=$row['time'];
										$logfunc=$row['func'];
										echo "<tr>
											<td>$loguser</td>
											<td>$logip</td>
											<td>$logloc</td>
											<td>$logtime</td>
											<td>$logfunc</td>
										</tr>";
									}
									unset($row);
									mysqli_free_result($result);
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>