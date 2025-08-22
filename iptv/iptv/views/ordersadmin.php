<?php require_once "view.section.php"; ?>

<!--页面主要内容-->
<main class="lyear-layout-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header"><h4>订单列表</h4></div>
					<div class="tab-content">
						<div class="tab-pane active">
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
									<tr>
										<th>账号</th>
										<th>订单编号</th>
										<th>购买套餐</th>
										<th>套餐期限</th>
										<th>支付状态</th>
									</tr>
									</thead>
									<tbody>
										<?php
											$meals=$db->mQuery("select id,name from iptv_meals");
											if (mysqli_num_rows($meals)) {
												$meals_arr = [];
												while ($row = mysqli_fetch_array($meals, MYSQLI_ASSOC)) {
													$meals_arr[$row["id"]] = $row["name"];
												} 
												unset($row);
												mysqli_free_result($meals);
											} 
											$result=$db->mQuery("SELECT userid,order_id,meal,days,status from iptv_payment");
											while ($row=mysqli_fetch_array($result)) {
												$userid=$row['userid'];
												$order_id=$row['order_id'];
												$days=$row['days'];
												$status=$row['status'];
												if (!empty($meals_arr[$row["meal"]])) {
													$meal = $meals_arr[$row["meal"]];
												}
												if($days == 999){
													$exp="永久授权";
												} else {
													$exp=$days . "天";
												}
												if($status == 1){
													$payst="已支付";
												} elseif ($status == 0) {
													$payst='未支付';
												}
											echo "
											<tr>
												<td><a href='useradmin.php?keywords=$userid'>$userid</a></td>
												<td>$order_id</td>
												<td>$meal</td>
												<td>$exp</td>
												<td>$payst</td>
											</tr>";
											}
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
</main>
<!--End 页面主要内容-->
</div>
</div>