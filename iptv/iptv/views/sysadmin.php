<?php require_once "view.section.php";require_once "../apps/sysadminController.php" ?>
<script type="text/javascript">
function showli(index){
	$(".main-content li").hide();
	$($(".main-content li")[index]).fadeIn();
	showindex=index;
}
showindex=<?php echo $_GET['index']; ?>
</script>
    <!--页面主要内容-->
    <main class="lyear-layout-content">
		<div class="container-fluid">
			<div class='main-content'>
				<ul class='list-unstyled'>
					<li>
						<?php include "./sysadmin/notice.view.php" ?>
					</li>
					<li>
						<?php include "./sysadmin/bgpic.view.php" ?>
					</li>
					<li>
						<?php include "./sysadmin/adminrec.view.php" ?>
					</li>
					<li>
						<?php include "./sysadmin/panelset.view.php" ?>
					</li>
					<li>
						<?php include "./sysadmin/appset.view.php" ?>
					</li>
					<li>
						<?php include "./sysadmin/admins.view.php" ?>
					</li>
				</ul>
			</div>
		</div>
    </main>
    <!--End 页面主要内容-->
  </div>
</div>

<script type="text/javascript">
showli(showindex);
$('.sysadmin').toggleClass( 'open' );
</script>