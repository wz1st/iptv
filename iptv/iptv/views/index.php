<?php require_once "view.section.php";require_once "../apps/indexController.php"; ?>

<!--页面主要内容-->
<main class="lyear-layout-content">
	<div class="container-fluid">
    
        <div class="row">
          <div class="col-sm-6 col-lg-3">
            <div class="card bg-primary">
              <div class="card-body clearfix">
                <div class="pull-right">
                  <p class="h6 text-white m-t-0">用户总数</p>
                  <p class="h3 text-white m-b-0"><?php echo $userCount; ?></p>
                </div>
                <div class="pull-left"> <span class="img-avatar img-avatar-48 bg-translucent"><i class="mdi mdi-account fa-1-5x"></i></span> </div>
              </div>
            </div>
          </div>
          
          <div class="col-sm-6 col-lg-3">
            <div class="card bg-danger">
              <div class="card-body clearfix">
                <div class="pull-right">
                  <p class="h6 text-white m-t-0">异常用户</p>
                  <p class="h3 text-white m-b-0"><?php echo $exceptionuserCount; ?></p>
                </div>
                <div class="pull-left"> <span class="img-avatar img-avatar-48 bg-translucent"><i class="mdi mdi-account-alert fa-1-5x"></i></span> </div>
              </div>
            </div>
          </div>
          
          <div class="col-sm-6 col-lg-3">
            <div class="card bg-purple">
              <div class="card-body clearfix">
                <div class="pull-right">
                  <p class="h6 text-white m-t-0">今日上线</p>
                  <p class="h3 text-white m-b-0"><?php echo $todayuserCount; ?></p>
                </div>
                <div class="pull-left"> <span class="img-avatar img-avatar-48 bg-translucent"><i class="mdi mdi-play-protected-content fa-1-5x"></i></span> </div>
              </div>
            </div>
          </div>
          
          <div class="col-sm-6 col-lg-3">
            <div class="card bg-success">
              <div class="card-body clearfix">
                <div class="pull-right">
                  <p class="h6 text-white m-t-0">今日授权</p>
                  <p class="h3 text-white m-b-0"><?php echo $todayauthoruserCount; ?></p>
                </div>
                <div class="pull-left"> <span class="img-avatar img-avatar-48 bg-translucent"><i class="mdi mdi-account-check fa-1-5x"></i></span> </div>
              </div>
            </div>
          </div>
          
          <div class="col-sm-6 col-lg-3">
            <div class="card bg-cyan">
              <div class="card-body clearfix">
                <div class="pull-right">
                  <p class="h6 text-white m-t-0">频道分类数量</p>
                  <p class="h3 text-white m-b-0"><?php echo $categoryCount; ?></p>
                </div>
                <div class="pull-left"> <span class="img-avatar img-avatar-48 bg-translucent"><i class="mdi mdi-television-guide fa-1-5x"></i></span> </div>
              </div>
            </div>
          </div>
          
          <div class="col-sm-6 col-lg-3">
            <div class="card bg-info">
              <div class="card-body clearfix">
                <div class="pull-right">
                  <p class="h6 text-white m-t-0">套餐数量</p>
                  <p class="h3 text-white m-b-0"><?php echo $mealsCount; ?></p>
                </div>
                <div class="pull-left"> <span class="img-avatar img-avatar-48 bg-translucent"><i class="mdi mdi-shopping-music fa-1-5x"></i></span> </div>
              </div>
            </div>
          </div>
          
          <div class="col-sm-6 col-lg-3">
            <div class="card bg-warning">
              <div class="card-body clearfix">
                <div class="pull-right">
                  <p class="h6 text-white m-t-0">EPG数量</p>
                  <p class="h3 text-white m-b-0"><?php echo $epgCount; ?></p>
                </div>
                <div class="pull-left"> <span class="img-avatar img-avatar-48 bg-translucent"><i class="mdi mdi-television-guide fa-1-5x"></i></span> </div>
              </div>
            </div>
          </div>
        
          <div class="col-sm-6 col-lg-3">
            <div class="card bg-brown">
              <div class="card-body clearfix">
                <div class="pull-right">
                  <p class="h6 text-white m-t-0">频道总数量</p>
                  <p class="h3 text-white m-b-0"><?php echo $channelCount; ?></p>
                </div>
                <div class="pull-left"> <span class="img-avatar img-avatar-48 bg-translucent"><i class="mdi mdi-television-classic fa-1-5x"></i></span> </div>
              </div>
            </div>
          </div>
          
			<div class="card">
				<div class="card-body">
					<div class="card-header"><h4>频道分类统计</h4></div>
                	<div class="table-responsive">
						<table class="table table-hover">
							<thead>
							<tr>
								<th>#</th>
								<th>频道分类</th>
								<th>分类频道数量</th>
							</tr>
							</thead>
							<tbody>
								<?php
								$num=1;
								$result=$db->mQuery("SELECT name from iptv_category where (autocategory IS NULL OR autocategory!='on') order by id");
								while ($row=mysqli_fetch_array($result)) {
									$categoryname=$row['name'];
									if ($channelnumdata = $db->mGetRow("iptv_channels","count(*)","where category=".$db->safeSQLParam($categoryname))) {
									    $channelnum = $channelnumdata[0];
									} else {
									    $channelnum = 0;
									} 
									unset($channelnumdata);
									echo "<tr>
										<td>$num</td>
										<td>$categoryname</td>
										<td>$channelnum</td>
									</tr>";
									$num++;
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
</main>
<!--End 页面主要内容-->

  </div>
</div>