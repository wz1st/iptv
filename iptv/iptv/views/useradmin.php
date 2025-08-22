<?php require_once "view.section.php";require_once "../apps/useradminController.php"; ?>

<script type="text/javascript">
	function submitForm(){
		var form = document.getElementById("recCounts");
		form.submit();
	}
	function quanxuan(a){
		var ck=document.getElementsByName("id[]");
		for (var i = 0; i < ck.length; i++) {
			if(a.checked){
				ck[i].checked=true;
			}else{
				ck[i].checked=false;
			}
		}
	}
</script>
    
    <!--页面主要内容-->
	<main class="lyear-layout-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header"><h4>已授权用户列表</h4></div>
						<div class="card-toolbar clearfix">
							<div class="btn-block" >
								<label>用户总数：<?php echo $userCount; ?></label>
								<label>今日上线：<?php echo $todayuserCount; ?></label>
								<label>今日授权：<?php echo $todayauthoruserCount; ?></label>
								<label>过期用户：<?php echo $expuserCount; ?></label>
							</div>
							<form class="pull-right search-bar" method="GET">
								<div class="input-group">
									<div class="input-group-btn">
										<input class="form-control" style="width: 225px;" type="text" name="keywords" value="<?php echo $keywords;?>" placeholder="请输入名称">
										<button class="btn btn-default" type="submit">搜索</button>
									</div>
								</div>
							</form>
	                		<div class="toolbar-btn-action">
								<form class="pull-left" method="POST" id="recCounts">
										<label>每页</label>
										<select class="btn btn-sm btn-default dropdown-toggle" id="sel" name="recCounts" onchange="submitForm();">			
											<?php
											switch ($recCounts) {
												case '20':
													echo "<option value=\"20\" selected=\"selected\">20</option>";
													echo "<option value=\"50\">50</option>";
													echo "<option value=\"100\">100</option>";
													break;
												case '50':
													echo "<option value=\"20\">20</option>";
													echo "<option value=\"50\" selected=\"selected\">50</option>";
													echo "<option value=\"100\">100</option>";
													break;
												case '100':
													echo "<option value=\"20\">20</option>";
													echo "<option value=\"50\">50</option>";
													echo "<option value=\"100\" selected=\"selected\">100</option>";
													break;
												
												default:
													echo "<option value=\"20\" selected=\"selected\">20</option>";
													echo "<option value=\"50\">50</option>";
													echo "<option value=\"100\">100</option>";
													break;
											}
											?>			
										</select><label>&nbsp;条</label>
								</form>
								<form class="pull-left" method="post" id="jumpto">
									<input type="text" name="jumpto" style="border-width: 0px;text-align: right;" size=2 value="<?php echo $page?>">/<?php echo $pageCount?>
									<button class="btn btn-xs btn-default" type="submit">跳转</button>
								</form>
							</div>
						</div>
						<div class="tab-content">
							<div class="tab-pane active">
								<div class="form-group">
                				<div class="table-responsive">
									<table class="table table-hover">
										<thead>
										<tr>
											<th class="w-1">
												<label class="lyear-checkbox checkbox-primary">
													<input type="checkbox" onclick="quanxuan(this)">
													<span></span>
												</label>
											</th>
											<th class="w-5"><a href="?order=name">账号</a></th>
											<th class="w-10"><a href="?order=meal">套餐</a></th>
											<th class="w-15"><a href="?order=mac">MAC地址</a></th>
											<th class="w-15"><a href="?order=deviceid">设备ID</a></th>
											<th class="w-10"><a href="?order=model">型号</a></th>
											<th class="w-10"><a href="?order=ip">IP</a></th>
											<th class="w-15"><a href="?order=region">地区</a></th>
											<th class="w-15"><a href="?order=lasttime">最后登陆</a></th>
											<th class="w-5"><a href="?order=exp">状态</a></th>
											<th class="w-5"><a href="?order=author">授权人</a></th>
											<th class="w-10"><a href="?order=marks">备注</a></th>
										</tr>
										</thead>
										<tbody>
											<form method="POST">
												<?php
													$recStart=$recCounts*($page-1);
													if($user=='admin'){
													$func="select status,name,mac,deviceid,model,ip,region,lasttime,exp,author,marks,vpn,meal from iptv_users where status>0 $searchparam order by $order limit $recStart,$recCounts";
													}else{
														$func="select status,name,mac,deviceid,model,ip,region,lasttime,exp,author,marks,vpn,meal from iptv_users where status>0 and author='$user' $searchparam order by $order limit $recStart,$recCounts";
													}
													$meals=$db->mQuery("select id,name from iptv_meals");
													if (mysqli_num_rows($meals)) {
														$meals_arr = [];
														while ($row = mysqli_fetch_array($meals, MYSQLI_ASSOC)) {
															$meals_arr[$row["id"]] = $row["name"];
														} 
														unset($row);
														mysqli_free_result($meals);
													} 
													$result=$db->mQuery($func);
													if (mysqli_num_rows($result)) {
														while($row=mysqli_fetch_array($result)){
															$status=$row['status'];
															$lasttime=date("Y-m-d H:i:s",$row['lasttime']);
															$days=ceil(($row['exp']-time())/86400);
															$expdate="到期时间：".date("Y-m-d H:i:s",$row['exp']);
															$name=$row['name'];
															$deviceid=$row['deviceid'];
															$mac=$row['mac'];
															$model=$row['model'];
															$ip=$row['ip'];
															$region=$row['region'];
															$author=$row['author'];
															$marks=$row['marks'];
															$vpn=$row['vpn'];
															if (empty($meals_arr[$row["meal"]])) {
																$meal = $row["meals"];
															} else {
																$meal = $meals_arr[$row["meal"]];
															} 
															if($row['exp']>time()){$days='剩'."$days".'天';}
															if($row['exp']<time()){
																$days='过期';
															}
															if($status==999){
																$days='永不到期';
																$expdate=$days;
															}
															echo "<tr class=\"h-5\">
																<td><label class=\"lyear-checkbox checkbox-primary\">
																<input type=\"checkbox\" name=\"id[]\" value=\"$name\"><span></span>
																</label></td>
																<td>$name</td>
																<td>$meal</td>
																<td>$mac</td>
																<td>".$deviceid."</td>
																<td>$model</td>
																<td>".$ip."</td>
																<td>".$region."</td>
																<td>".$lasttime ."</td>
																<td title='$expdate'>".$days."</td>
																<td>".$author."</td>
																<td>$marks</td>
																</tr>";
														}
														unset($row);
													}else {
													    echo "<tr><td align='center' colspan='12'><font color='red'>对不起，当前未有已授权的用户数据！</font></td></tr>";
													}
													mysqli_free_result($result);
																?>
												<div class="form-inline pull-left">
												<tr>
													<td colspan="12">
														<div class="input-group">
															<div class="input-group-btn">
																<select class="btn btn-sm btn-default dropdown-toggle" style="width: 115px;height: 30px;" name="s_meals">
																	<option value="">请选择套餐</option>
																	<?php 
																		foreach($meals_arr as $mealid => $mealname) {
																			echo "<option value=\"$mealid\">$mealname";
																		} 
																		unset($meals_arr);
																	?>
																</select>
																<button class="btn btn-sm btn-primary m-r-10" type="submit" name="e_meals">修改套餐</button>
																<input class="btn btn-default " style="width: 115px;height: 30px;" type="text" name="marks" size="3" placeholder="请输入备注">
																<button class="btn btn-sm btn-primary m-r-10" type="submit" name="submitmodifymarks">修改备注</button>
																<input class="btn btn-default " style="width: 85px;height: 30px;" type="text" name="exp" size="3" placeholder="授权天数">
																<button class="btn btn-sm btn-primary m-r-10" type="submit" name="submitmodify">修改天数</button>
																<button class="btn btn-sm btn-primary m-r-10" type="submit" name="submitadddays">增加天数</button>
																<button class="btn btn-sm btn-primary m-r-10" type="submit" name="submitNotExpired">设为永不到期</button>
																<button class="btn btn-sm btn-primary m-r-10" type="submit" name="submitCancelNotExpired">取消永不到期</button>
																<button class="btn btn-sm btn-primary m-r-10" type="submit" name="submitforbidden">取消授权</button>
																<button class="btn btn-sm btn-primary m-r-10" type="submit" name="submitdel" onclick="return confirm('确定删除选中用户吗？')">删除</button>
																<button class="btn btn-sm btn-primary" type="submit" name="submitdelall" onclick="return confirm('确认删除所有已过期授权信息？')">清空过期用户</button>
															</div>
														</div>
													</td>
												</tr>
												</div>
											</form>
										</tbody>
									</table>
								</div>
								</div>
								<nav>
									<ul class="pager">
										<li><a href="<?php if($page>1){$p=$page-1;}else{$p=1;} echo '?page='.$p.'&order='.$order.'&keywords='.$keywords?>">上一页</a></li>
										<li class="previous"><a href="<?php echo '?page=1&order='.$order.'&keywords='.$keywords?>">首页</a></li>
										<li class="next"><a href="<?php echo '?page='.$pageCount.'&order='.$order.'&keywords='.$keywords?>">尾页</a></li>
										<li><a href="<?php if($page<$pageCount){$p=$page+1;} else {$p=$page;} echo '?page='.$p.'&order='.$order.'&keywords='.$keywords?>">下一页</a></li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </main>
    <!--End 页面主要内容-->
  </div>
</div>