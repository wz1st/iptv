<?php
//修改EPG数据
if ($_GET["act"] == "edits") {
    $id = !empty($_POST["id"])?$_POST["id"]:exit("<script>$.alert({title: '错误',content: '参数为空！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location='epgadmin.php';}}}});</script>");
    $epg = !empty($_POST["epg"])?$_POST["epg"]:exit("<script>$.alert({title: '错误',content: '请选择EPG来源！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    $name = !empty($_POST["name"])?$_POST["name"]:exit("<script>$.alert({title: '错误',content: '请填写EPG名称！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    $epg_name = $epg . '-' . $name;
    $ids = !empty($_POST['ids']) ? implode(",", array_unique($_POST['ids'])) : '';
    $remarks = $_POST["remarks"];
    $db->mSet("iptv_epg", "name='" . $epg_name . "',content='" . $ids . "',remarks='" . $remarks . "'", "where id=" . $id);
    exit("<script>$.alert({title: '成功',content: 'EPG " . $epg_name . " 修改成功！',type: 'green',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location='epgadmin.php';}}}});</script>");
} 
if ($_GET["act"]=="edit") { 
    $id=!empty($_GET["id"])?$_GET["id"]:exit("<script>$.alert({title: '错误',content: '参数为空！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location='epgadmin.php';}}}});</script>");
    //检查EPG是否存在
    $result=$db->mQuery("select name,content,remarks from iptv_epg where id=".$db->safeSQLParam($id));
    if (!mysqli_num_rows($result)) {
        mysqli_free_result($result);
        exit("<script>$.alert({title: '错误',content: 'EPG不存在！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
    }
    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
    $content=$row["content"];
    $remarks=$row["remarks"];
    if(strstr($row["name"],"cntv") != false){
        $epgname = substr($row["name"], 5);
        $epgopt = '<option value="cntv" selected>CCTV官网</option><option value="tvming">天脉聚源</option><option value="tvmao">电视猫</option><option value="tvsou">搜视网</option><option value="51zmt">51zmt</option><option value="112114">112114</option>';
    }else if(strstr($row["name"],"tvming") != false){
        $epgname = substr($row["name"], 7);
        $epgopt = '<option value="cntv">CCTV官网</option><option value="tvming" selected>天脉聚源</option><option value="tvmao">电视猫</option><option value="tvsou" >搜视网</option><option value="51zmt">51zmt</option><option value="112114">112114</option>';
    }else if(strstr($row["name"],"tvmao") != false){
        $epgname = substr($row["name"], 6);
        $epgopt = '<option value="cntv">CCTV官网</option><option value="tvming">天脉聚源</option><option value="tvmao"  selected>电视猫</option><option value="tvsou">搜视网</option><option value="51zmt">51zmt</option><option value="112114">112114</option>';
    }else if(strstr($row["name"],"tvsou") != false){
        $epgname = substr($row["name"], 6);
        $epgopt = '<option value="cntv">CCTV官网</option><option value="tvming">天脉聚源</option><option value="tvmao">电视猫</option><option value="tvsou"  selected>搜视网</option><option value="51zmt">51zmt</option><option value="112114">112114</option>';
    }else if(strstr($row["name"],"51zmt") != false){
        $epgname = substr($row["name"], 6);
        $epgopt = '<option value="cntv">CCTV官网</option><option value="tvming">天脉聚源</option><option value="tvmao">电视猫</option><option value="tvsou">搜视网</option><option value="51zmt"  selected>51zmt</option><option value="112114">112114</option>';
    }else if(strstr($row["name"],"112114") != false){
        $epgname = substr($row["name"], 7);
        $epgopt = '<option value="cntv">CCTV官网</option><option value="tvming">天脉聚源</option><option value="tvmao">电视猫</option><option value="tvsou">搜视网</option><option value="51zmt">51zmt</option><option value="112114"  selected>112114</option>';
    }
    unset($row);
    mysqli_free_result($result);
    //获取频道内容
    $result=$db->mQuery("SELECT distinct name FROM iptv_channels order by category,id");
    if (!mysqli_num_rows($result)) {
        mysqli_free_result($result);
        exit("<script>$.alert({title: '错误',content: '对不起，无法生成频道信息！',type: 'red',buttons: {confirm: {text: '确定',btnClass: 'btn-primary',action: function(){self.location=document.referrer;}}}});</script>");
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
$("#listctr").hide();
</script>

<table class="table table-bordered table-striped table-vcenter" align="center">
    <form method="post" action="?act=edits">
        <tr>
            <td>
                <div class="input-group">
                    <div class="input-group-btn">
                        <select class="form-control btn btn-default dropdown-toggle" style="width: 125px;" id="epg" name="epg" >
                            <option value="">请选EPG来源</option>
                            <?=$epgopt?>
                        </select>&nbsp;&nbsp;
                        <input class="form-control" type="text" name="name" style="width: 125px;" placeholder="EPG名称" value="<?php echo $epgname;?>">
                        <input class="form-control" type="text" name="remarks" style="width: 185px;" placeholder="多个备注请用 | 分隔开" value="<?php echo $remarks;?>">
                        <input type="hidden" name="id" style="width: 0px;" value="<?php echo $id;?>">
                        <button class="btn btn-default"  type="submit" name="bindchannel" onclick="return confirm('自动绑定频道列表后,如果不准确请手动修改!!!')">搜索绑定频道</button>
                        <button class="btn btn-default"  type="submit" name="clearbind" onclick="return confirm('确定要清空绑定的频道列表吗？')">清空绑定</button>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <p align="left"><input type="checkbox" onclick="quanxuan(this)">全选/反选</p>
                <?php
                while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                    $channelname=$row["name"];
                    $channelcategory=$row["category"];
                    if(in_array($channelname,explode(',', $content))){
                        echo "<div style=' float: left;background: #7fff00; margin-right: 3px; margin-bottom: 3px; padding: 2px 5px;'><input type='checkbox' value='".$channelname."' name='ids[]'  checked=\"checked\">".$channelname."</div>";
                    }else {
                        echo "&nbsp;&nbsp;<div style=' float: left;background: #E7E7E7; margin-right: 3px; margin-bottom: 3px; padding: 2px 5px;'><input type='checkbox' value='".$row["name"]."' name='ids[]' >".$row["name"]."</div>";
                    }
                    unset($channelname);
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