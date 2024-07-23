<style type="text/css">
	form{margin:0px;display: inline}
	td{padding: 8px;}

</style>

<?php
ini_set('display_errors',1);            
ini_set('display_startup_errors',1);   
error_reporting(E_ERROR);

 require_once "view.section.php";
 require_once "../apps/sysadminController.php" ;
//if($_SESSION['author1']==0)
//	exit("<center><font color='red'>对不起，当前账号未有权限操作，请与管理员联系！</font></center>");

if(isset($_POST['movie_name'])){
	$name=$_POST['movie_name'];
	$api=$_POST['movie_api'];
	$sql="INSERT into dsmtv_movie (name,api,state) values('$name','$api',1)";
	$db->mQuery($sql);
	//mysqli_query($con,$sql);
}

if(isset($_POST['movie_edit_id'])){
	$id=$_POST['movie_edit_id'];
	$movie_edit_api=$_POST['movie_edit_api'];
	$movie_edit_name=$_POST['movie_edit_name'];
	$sql="UPDATE dsmtv_movie SET name = '$movie_edit_name' ,api = '$movie_edit_api' where id =".$id;
	$db->mQuery($sql);
}

if(isset($_GET['delete'])){
	$id=$_GET['id'];
	$sql="delete from dsmtv_movie where id =".$id;
	$db->mQuery($sql);
}

if(isset($_GET['toggle'])){
	$id=$_GET['id'];
	$state=$_GET['toggle'];
	$sql="update dsmtv_movie set state = ".$state." where id =".$id;
	$db->mQuery($sql);
}



//getTable
$result=$db->mQuery("select * from dsmtv_movie");
$tableBody="";
$index_table=0;
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
	$index_table++;
	$state = $row["state"]=="1"?"<span class='label label-success'>上线</span>":"<span class='label label-danger'>停用</span>";
	$state_edit = $row["state"]=="1"?"<a style='width:100px;margin-left:5px;' class='btn btn-sm btn-danger' href='movie.php?toggle=0&id=".$row['id']."'>停用</a>":"<a style='width:100px;margin-left:5px;' class='btn btn-sm btn-success' href='movie.php?toggle=1&id=".$row['id']."'>上线</a>";
	$tableBody.="<tr><td>".$index_table."</td><td>".$row["name"]."</td><td>".$state."</td><td>".$row["api"]."</td><td>".$state_edit."<button style='width:100px;margin-left:5px;' class='btn btn-sm btn-primary' data-toggle='modal' data-target='#myModal' onclick='edit(\"".$row["name"]."\",\"".$row["api"]."\",".$row['id'].")'>编辑</button><a style='width:100px;margin-left:5px;' class='btn btn-sm btn-warning' href='movie.php?delete=1&id=".$row['id']."'>删除</a></td><td><tr>";
}
mysqli_free_result($result);
?>
<br>
<script type="text/javascript">
function edit(arg,arg1,arg2) {
	// body...
	document.getElementById('sig_name').value = arg;
	document.getElementById('sig_id').value = arg2;
	document.getElementById('sig_api').value = arg1;
}
</script>
<html>
    123
</html>
<main class="lyear-layout-content">
	<div class="container-fluid">
		<div class="card">
			<div class="row">
				<div class="row m-b-10" >
					<div class="col-md-12">
						<div class="card-header">
							<h3>点播管理</h3>
						</div>
						<div class="card-body" style="margin: 10px;color: gray;font-size: 18px;min-height: 800px;">
							<form method="post">
								
							
							接口名称：
							<input name="movie_name" style="width: 30%;display: inline;margin-right: 10px;" type="text" class="form-control" placeholder="">
							接口地址：
							<input name="movie_api" style="width: 40%;display: inline;" type="text" class="form-control" placeholder="http://..cms">
							<div style="margin-top: 10px;">
								<input  type="submit" value="新增接口" class="btn btn-primary">
								<input  type="reset" value="重置" class="btn btn-primary">
							</div>
							</form>
							<table class="table table-hover" style="margin-top: 10px;">
								<thead>
									<tr>
									<th>资源库</th>
										<th>资源名称</th>
										<th>状态</th>
										<th>接口地址</th>
										<th>操作</th>
										</tr>
									</thead>
									<tbody>
									<?php echo $tableBody; ?>
										
									</tbody>
								</table>

							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">编辑</h4>
            </div>
            <div class="modal-body">
            <form method="post">
            	<input id="sig_id" name="movie_edit_id" style="display: none;" >
            	接口名称：
							<input id="sig_name" name="movie_edit_name" style="width: 30%;display: inline;margin-right: 10px;" type="text" class="form-control" placeholder="接口地址啦...比如EZ视屏网">
							接口地址：
							<input id="sig_api" name="movie_edit_api" style="width: 40%;display: inline;" type="text" class="form-control" placeholder="http://..cms">
           
            	

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="submit" class="btn btn-primary">确认提交</button>
            </div>
             </form>
        </div>
    </div>
</div>
</main>

<script>
	function showli(){
		window.location.href="sysadmin.php";
	}
	$(function(){
 //#table表示的是上面table表格中的id
 $("#user0_table").bootstrapTable('destroy').bootstrapTable({
 	fixedColumns: true, 
        fixedNumber: 1 //固定列数
    });
})
</script>