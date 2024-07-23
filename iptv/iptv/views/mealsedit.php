<?php
//套餐修改区域
if ($_GET["act"]=="edits") {
	$id=!empty($_POST["id"])?$_POST["id"]:exit("<script>$.alert({title: '错误',content: '参数为空！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location='mealsadmin.php';}}}});</script>");
	$amount=!empty($_POST["amount"])?$_POST["amount"]:exit("<script>$.alert({title: '错误',content: '金额参数为空！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location='mealsadmin.php';}}}});</script>");
	$days=!empty($_POST["days"])?$_POST["days"]:exit("<script>$.alert({title: '错误',content: '期限参数为空！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location='mealsadmin.php';}}}});</script>");
	$meal_name=!empty($_POST["name"])?$_POST["name"]:exit("<script>$.alert({title: '错误',content: '请填写套餐名称！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
	$ids="";
	if (!empty($_POST["ids"])) {
		foreach ($_POST["ids"] as $num=>$content ) {
			$ids.=$content;
			if (($num+1)<count($_POST["ids"])) {
				$ids.="_";
			}
		}
	}
    $db->mSet("iptv_meals", "name='".$meal_name."',content='".$ids."',amount='".$amount."',days='".$days."'", "where id=" . $id);
	exit("<script>$.alert({title: '成功',content: '套餐 " . $meal_name . " 修改成功！',type: 'green',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location='mealsadmin.php';}}}});</script>");
}
if ($_GET["act"]=="edit") { 
	$id=!empty($_GET["id"])?$_GET["id"]:exit("<script>$.alert({title: '错误',content: '参数为空！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location='mealsadmin.php';}}}});</script>");
	//检查套餐是否存在
	$result=$db->mQuery("SELECT name,content,amount,days FROM iptv_meals WHERE id=".$id);
	if (!mysqli_num_rows($result)) {
		mysqli_free_result($result);
		exit("<script>$.alert({title: '错误',content: '套餐不存在！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location='mealsadmin.php';</script>");
	}
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
	$mealname=$row["name"];     //套餐名称
	$amount=$row["amount"];   //套餐金额
	$days=$row["days"];   //套餐期限
	$content=$row["content"];   //套餐内容
	unset($row);
	mysqli_free_result($result);
	//获取套餐所有的收视内容
	$result=$db->mQuery("SELECT id,name from iptv_category where enable=1 and (autocategory IS NULL OR autocategory!='on') ORDER BY id ASC");
	if (!mysqli_num_rows($result)) {
		mysqli_free_result($result);
		exit("<script>$.alert({title: '错误',content: '对不起，没有频道分类信息，无法生成套餐！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location='mealsadmin.php'}}}});</script>");
	}
?>

<script type="text/javascript">
function quanxuan(a){
	var ck=document.getElementsByName("ids[]");
	for (var i = 0; i < ck.length; i++) {
		var tr=ck[i].parentNode.parentNode;
		if(a.checked){
			ck[i].checked=true;
		}else{
			ck[i].checked=false;
		}
	}
}
</script>

	<table class="table table-bordered table-striped table-vcenter" align="center">
		<form method="post" action="?act=edits">
		<tr>
			<td>
				<div class="form-inline">
					<input type="hidden" name="id" value="<?php echo $id;?>">
					<label class="control-label">套餐名称：</label>
					<input class="form-control" type="text" name="name" value="<?php echo $mealname;?>">
					<label class="control-label">套餐金额：</label>
					<input class="form-control" type="text" name="amount" value="<?php echo $amount;?>">
					<label class="control-label">套餐期限：</label>
					<input class="form-control" type="text" name="days" value="<?php echo $days;?>">
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<label class="lyear-checkbox m-b-10">
					<input type="checkbox" onclick="quanxuan(this)">
					<span>全选/反选</span>
				</label>
				<?php
				while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
					$categoryname=$row["name"];
					if (strpos($content,$categoryname) !==false) {
						echo "<label class=\"lyear-checkbox checkbox-inline\"><input type='checkbox' value='".$categoryname."' name='ids[]'  checked=\"checked\"><span>$categoryname</span></label>";
					}else {
						echo "<label class=\"lyear-checkbox checkbox-inline\"><input type='checkbox' value='".$categoryname."' name='ids[]' ><span>$categoryname</span></label>";
					}
					unset($categoryname);
				}
				unset($row);
				mysqli_free_result($result);
				?>
			</td>
		</tr>
		<tr align="center">
			<td>
				<input type="submit" value="确认修改">
			</td>
		</tr>
		</form>
	</table>
<?php exit;}?>