var down_count = 0;
var getProtocol = window.location.protocol;
var getHost = window.location.host;
var apkurl = getProtocol + "//" + getHost + "/app/DSMTV.apk";
function isValidIP(ip){
	return /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/.test(ip);
};
var check_connect = function(tp, ip, port){
	var httpdz = ip + ":" + port;
	$.ajax({url: getProtocol + httpdz + "/down_status",
		timeout: 3000,
		dataType: "json",
		success:function(obj) {
			$.get(getProtocol + httpdz + "/app_install?url=" + encodeURIComponent(apkurl), function(d){
				if (d.suc == 0) {
					$("#downurl").text(httpdz + "已推送安装");
					down_count++;
				}
			}, "json");
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			if (tp == 0) {
				check_connect(1, ip, 8053);
			}
		}
	});
};
var download = function() {
	if (down_count == 0) {
		window.location.href = apkurl;
	}
}
var loading = function() {
	window.location.href = apkurl;
	// var ip = prompt("请输入路由器IP进行安装","");
	// if (isValidIP(ip)) {
	// 	var ips = ip.split(".");
	// 	var newip = ips[0] + "." + ips[1] + "." + ips[2] + ".";
	// 	for(var i=0; i < 255;i++){
	// 		check_connect(0, newip + i , 8051);
	// 	}
	// 	window.setTimeout("download()", 3000);
	// } else {
	// 	window.location.href = apkurl;
	// }
}
