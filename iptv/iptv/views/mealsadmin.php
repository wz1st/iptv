<?php require_once "view.section.php";require_once "../apps/mealsadminController.php"; ?>

<script type="text/javascript">
function submitForm(){
    var form = document.getElementById("recCounts");
    form.submit();
}
</script>

<!--页面主要内容-->
<main class="lyear-layout-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header"><h4>套餐列表</h4></div>
					<div class="tab-content">
						<div class="tab-pane active">
							<div class="form-group">
								<div class="table-responsive" >
									<?php require_once "mealsedit.php" ?>
									<table class="table table-hover table-vcenter">
										<tr>
											<td colspan="5">
												<form class="form-inline" method="post" action="?act=add">
													<label class="control-label">套餐名称:</label>
													<input class="form-control" type="text" name="name">
													<button class="btn btn-default" type="submit">新增套餐</button>
													<button class="btn btn-default" type="reset">重置</button>
												</form>
											</td>
										</tr>
										<tr align="center">
											<td class="w-5">套餐编号</td>
											<td class="w-5">套餐名称</td>
											<td class="w-5">套餐金额</td>
											<td class="w-5">套餐期限</td>
											<td class="w-5">套餐状态</td>
											<td class="w-15">收视内容</td>
											<td class="w-5">操作</td>
										</tr>
										<tbody style="font-size:12px;font-weight: bold;">
											<?php
											//获取套餐数据显示
											$result=$db->mQuery("select * from iptv_meals");
											if (!mysqli_num_rows($result)) {
												echo"<tr>";
												echo"<td colspan=\"5\" align=\"center\" style=\"font-size:14px;color:red;height:35px;font-weight: bold;\">当前未有套餐数据！";
												echo"</td>";
												echo"</tr>";
												mysqli_free_result($result);
											}
											while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
												if ($row["status"]) {
													$status="<font color=\"#33a996\">上线</font>";
													$func="<a href=\"?act=downline&id=".$row["id"]."\"><font color=\"red\">下线</font></a>";
												}else {
													$status="<font color=\"red\">下线</font>";
													$func="<a href=\"?act=online&id=".$row["id"]."\"><font color=\"#33a996\">上线</font></a>";
												}
												if ($row["days"] == 999) {
													$days = "永久授权";
												} else {
													$days = $row["days"] . "天";
												}
												echo"<tr>";
												echo"<td align=\"center\" style=\"font-size:12px;height:35px;font-weight: bold;\">".$row["id"]."</td>";
												echo"<td align=\"center\" style=\"font-size:12px;font-weight: bold;\">".$row["name"]."</td>";
												echo"<td align=\"center\" style=\"font-size:12px;font-weight: bold;\">".$row["amount"]."元</td>";
												echo"<td align=\"center\" style=\"font-size:12px;font-weight: bold;\">".$days."</td>";
												echo"<td align=\"center\" style=\"font-size:12px;font-weight: bold;\">".$status."</td>";
												echo"<td align=\"left\" style=\"font-size:12px;font-weight: bold;\">".$row["content"]."</td>";
												echo"<td align=\"center\" style=\"font-size:12px;font-weight: bold;\">
												".$func."&nbsp;
												<a href=\"?act=edit&id=".$row["id"]."\">编辑</a>&nbsp;
												<a href=\"?act=dels&id=".$row["id"]."\"><font color=\"#8E388E\">删除</font></a>
												</td>";
												echo"</tr>";
											}
											unset($row);
											mysqli_free_result($result);
											?>
										</tbody>
									</table>
									<table align="center">
										<td style="font-size:14px;font-weight:bold;color:red;">
											注：套餐新增加最大可以支持20个！
										</td>
									</table>
								</div>
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