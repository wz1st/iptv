<?php require_once "view.section.php";require_once "../apps/channeladminController.php" ?>
<script>
	(function($){$.session={_id:null,_cookieCache:undefined,_init:function()
	{if(!window.name){window.name=Math.random();}
	this._id=window.name;this._initCache();var matches=(new RegExp(this._generatePrefix()+"=([^;]+);")).exec(document.cookie);if(matches&&document.location.protocol!==matches[1]){this._clearSession();for(var key in this._cookieCache){try{window.sessionStorage.setItem(key,this._cookieCache[key]);}catch(e){};}}
	document.cookie=this._generatePrefix()+"="+ document.location.protocol+';path=/;expires='+(new Date((new Date).getTime()+ 120000)).toUTCString();},_generatePrefix:function()
	{return'__session:'+ this._id+':';},_initCache:function()
	{var cookies=document.cookie.split(';');this._cookieCache={};for(var i in cookies){var kv=cookies[i].split('=');if((new RegExp(this._generatePrefix()+'.+')).test(kv[0])&&kv[1]){this._cookieCache[kv[0].split(':',3)[2]]=kv[1];}}},_setFallback:function(key,value,onceOnly)
	{var cookie=this._generatePrefix()+ key+"="+ value+"; path=/";if(onceOnly){cookie+="; expires="+(new Date(Date.now()+ 120000)).toUTCString();}
	document.cookie=cookie;this._cookieCache[key]=value;return this;},_getFallback:function(key)
	{if(!this._cookieCache){this._initCache();}
	return this._cookieCache[key];},_clearFallback:function()
	{for(var i in this._cookieCache){document.cookie=this._generatePrefix()+ i+'=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';}
	this._cookieCache={};},_deleteFallback:function(key)
	{document.cookie=this._generatePrefix()+ key+'=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';delete this._cookieCache[key];},get:function(key)
	{return window.sessionStorage.getItem(key)||this._getFallback(key);},set:function(key,value,onceOnly)
	{try{window.sessionStorage.setItem(key,value);}catch(e){}
	this._setFallback(key,value,onceOnly||false);return this;},'delete':function(key){return this.remove(key);},remove:function(key)
	{try{window.sessionStorage.removeItem(key);}catch(e){};this._deleteFallback(key);return this;},_clearSession:function()
	{try{window.sessionStorage.clear();}catch(e){for(var i in window.sessionStorage){window.sessionStorage.removeItem(i);}}},clear:function()
	{this._clearSession();this._clearFallback();return this;}};$.session._init();})(jQuery);
</script>

<script>
	function categorycheck(cname){
		$.get("../apps/togglepdController.php?cname="+cname,function(data){$("#tip").html(data)});
	}
	function showlist(index){
		$("#srclist").val("正在加载中...");
		$("#srclist").load("../apps/listController.php?category="+cname[index],function(data){
			$("#srclist").val(data);
		});
		$("#typename").val(cname[index]);
		$("#typename0").val(cname[index]);
		$("#typepass").val(cpass[index]);
		$("#category").val(cname[index]);
		$("#showindex").val(index);
		$("#showindextype").val(index);
		showindex=index;
		$.session.set("<?php echo '$showindex';?>",showindex);
	}
	if(showindex==-1) showindex=$.session.get("<?php echo '$showindex';?>");
</script>

<style type="text/css">
	#categorylist{padding-left: 0px;padding-top: 5px;}
	ul li{list-style: none}
</style>

<!--页面主要内容-->
<main class="lyear-layout-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header"><h4>频道设置</h4></div>
					<div class="tab-content">
						<div class="tab-pane active">
	                		<div class="table-responsive" >
								<table class="table table-bordered table-vcenter">
									<tr>
										<td>
											<form class="form-inline" method="post" id='autoupdate_form'>
											<label>列表设置：</label>
												<span>更新间隔</span>
												<input type="hidden" name="ver" value="<?php echo ($ver+1); ?>">
												<input type="text" name='updateinterval' style="width: 30px;height: 20px;" value="<?php echo $updateinterval ?>" size="5"><span>&nbsp;分</span>
												<label class="lyear-checkbox checkbox-inline">
													<input type="checkbox" name="autoupdate" value="<?php $autoupdate ?>" <?php echo $checktext ?>>
													<span>自动更新</span>
												</label>
												<button class="btn btn-xs btn-default" type="submit" name="submit"/>保存设定</button>
											</form>
										</td>
									</tr>
									<tr>
									<td>
										<form class="form-inline" method="post">
											<label>外部列表：</label>
											<div class="input-group">
												<div class="input-group-btn">
													<select class="btn btn-sm btn-default dropdown-toggle" name="thirdlist">
														<option selected="selected" value="">请选列表</option>
															<?php $result=$db->mQuery("SELECT name from iptv_category where type=".$db->safeSQLParam($categorytype)." and url is not null");
															while ($row=mysqli_fetch_array($result)) {
																$listname=$row['name'];
																echo "<option>$listname</option>";
															}
															unset($row);
															mysqli_free_result($result); ?>
													</select>
													<button id="updatelist" class="btn btn-sm btn-default" style="width: 85px;height: 26.5px;" type="submit" name="updatelist">更新列表</button>
												<button class="btn btn-sm btn-default" style="width: 85px;height: 26.5px;" type="button" data-toggle="modal" data-target="#addlist">导入列表</button>
												<button class="btn btn-sm btn-default" style="width: 85px;height: 26.5px;" type="submit" name="dellist">删除列表</button>
												</div>
											</div>
										</form>
									</td>
									</tr>
								</table>
								<div class="modal fade" id="addlist" tabindex="-1" role="dialog">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title">增加外部列表</h4>
											</div>
											<form method="post">
												<div class="modal-body">
													<div class="form-group">
														<label for="recipient-name" class="control-label">分类名称：</label>
														<input type="text" class="form-control" name="thirdlistcategory" placeholder="分类名称">
													</div>
													<div class="form-group">
														<label for="message-text" class="control-label">列表链接：</label>
														<input class="form-control" name="thirdlisturl" placeholder="请输入列表链接"></input>
													</div>
													<div class="form-group">
   														<input type="checkbox" name="autocategory" value="on"></input>
   														<label for="message-text" class="control-label">启用DIYP格式自动分类</label>
													</div>
												</div>
												<div class="modal-footer">
													<button type="submit" class="btn btn-primary" id="addthirdlist" name="addthirdlist">确定</button>
													<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<h4>
							<?php
							if (strpos($_SERVER['REQUEST_URI'],'default') !== false){ echo '默认频道'; }
							else if (strpos($_SERVER['REQUEST_URI'],'province') !== false){ echo '省份频道'; }
							else if (strpos($_SERVER['REQUEST_URI'],'chinanet') !== false){ echo '电信频道'; }
							else if (strpos($_SERVER['REQUEST_URI'],'unicom') !== false){ echo '联通频道'; }
							else if (strpos($_SERVER['REQUEST_URI'],'cmcc') !== false){ echo '移动频道'; }
							else if (strpos($_SERVER['REQUEST_URI'],'vip') !== false){ echo '会员频道'; }
							?>
						</h4>
					</div>
            			<div class="card-body">
	                		<div class="table-responsive" >
								<table class="table table-bordered table-vcenter" style="min-width:750px;">
										    <tr>
											    <td colspan="5">
							<form class="form-inline" method="post" style="padding: 0 15px 0 15px;">
								<label class="control-label">分类管理：</label>
								<div class="input-group">
									<div class="input-group-btn">
										<input type="hidden" id="showindextype" name="showindex" value=""/>
										<input type="hidden" id="typename0" name="typename0" value=""/>
										<input class="form-control" style="width: 108px;height: 30px;" id="typename" type="text" size="10" name="category" value="<?PHP echo $category?>" placeholder="分类名称"/>
										<input class="form-control" style="width: 115px;height: 30px;" id="typepass" type="text" size="10" name="cpass" value="<?PHP echo $cpass?>" placeholder="分类密码"/>
										<button class="btn btn-sm btn-default" type="submit" name="submit">增加分类</button>
										<button class="btn btn-sm btn-default" type="submit" name="submit_deltype">删除分类</button>
										<button class="btn btn-sm btn-default" type="submit" name="submit_modifytype">修改分类</button>
										<button class="btn btn-sm btn-default" type="submit" name="submit_moveup">上移分类</button>
										<button class="btn btn-sm btn-default" type="submit" name="submit_movedown">下移分类</button>
										<button class="btn btn-sm btn-default" type="submit" name="submit_movetop">移至最上</button>
									</div>
								</div>
							</form>
							</td>
							</tr>
							<tr>
							<td align="center" valign="top" style="float: left;padding: 40px 0 0 0;border-width: 0px;height: 800px;overflow:auto;">
								<div id="tip"></div>
								<script type="text/javascript">
									var cname=[];
									var cpass=[];
								</script>
								<div class="btn-group-vertical" style="padding-left: 15px;">
									<label class="btn-block">分类列表</label>
									<?php
										if ($categorytype=='vip'){
										$func = "SELECT name,psw,enable FROM iptv_category where type=".$db->safeSQLParam($categorytype)." and (autocategory IS NULL OR autocategory!='on') order by id";
										}else{
											$func = "SELECT name,psw,enable FROM iptv_category where (autocategory IS NULL OR autocategory!='on') and (type=".$db->safeSQLParam($categorytype)." or type='thirdlist') order by id";
										}
										$result = $db->mQuery($func);
										$index=0;
										while($row = mysqli_fetch_array($result)) {
											$cname=$row['name'];
											$enable=$row['enable'];
											$cpass=$row['psw'];
											if($enable==1){
												$check='checked=checked';
											}else{
												$check='';
											}
											if($cpass==''){
												$lockimg='';
											}else{
												$lockimg='*';
											}
											echo "<script>cname[$index]=".$db->safeSQLParam($cname).";cpass[$index]=".$db->safeSQLParam($cpass).";</script>";
											echo "
												<button id=\"categorylist\" class=\"btn btn-default\" onclick=\"showlist($index)\">
													<div class='categorylist' style='text-align:left;padding: 5px;'>
														<label class=\"lyear-checkbox checkbox-inline checkbox-cyan\">
															<input type=\"checkbox\" $check onclick='categorycheck(\"$cname\")'>
															<span></span>
														</label>				
														$cname $lockimg 
													</div>
												</button>";
											$index++;
										}
										unset($row);
										mysqli_free_result($result);
									?>
								</div>
							</td>
							<td align="center" valign="top" style="padding-top: 5px;width: 100%;">
								<form method="post">
									<div class="input-group">
										<div class="input-group-btn">
											<div class="col-xs-12" style="padding: 15px;">
												<button class="btn btn-sm btn-default" id="updatesrc" style="width:100%;" type="submit" name="submit">保存</button>
											</div>
											<input type="hidden" id="category" name="category" value=""/>
											<input type="hidden" id="showindex" name="showindex" value=""/>
											<div class="col-xs-12">
												<textarea class="form-control" id="srclist" name="srclist" rows="35" placeholder="节目列表"></textarea>
											</div>
										</div>
									</div>
								</form>
							</td>
							</tr>
						</table>
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

<script type="text/javascript">
	showlist(showindex);
	$('#updatelist').on('click', function(){
	    lightyear.loading('show');
	});
	$('#updatesrc').on('click', function(){
	    lightyear.loading('show');
	});
	$('#addthirdlist').on('click', function(){
	    lightyear.loading('show');
	});
	$('#dellist').on('click', function(){
	    lightyear.loading('show');
	});
	$('.channeladmin').toggleClass( 'open' );
</script>