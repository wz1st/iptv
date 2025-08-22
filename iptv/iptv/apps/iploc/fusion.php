<?php
header("Content-type: text/json; charset=utf-8");
header("Cache-Control:no-cache,must-revalidate");
header("Pragma: no-cache");
//引用必要的php文件
require 'ipv6data/ipdbv6.func.php';
error_reporting(E_ALL^E_NOTICE^E_WARNING); //关闭php报错显示
$ip = $_GET["ip"];
if ($ip == null) { //获得客户端ip地址（ipv6优先）
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		$ip = trim(current($ip));
	}
}

class IpLocation {
    // 数据文件指针
    var $fp;
    var $firstip;
    var $lastip;
    var $totalip;

    function getlong() {
        // unpack从二进制字符串对数据进行解包
        // 将读取的little-endian编码的4个字节转化为长整型数,fread安全读取二进制文件
        $result = unpack('Vlong', fread($this->fp, 4));
        return $result['long'];
    } 

    function getlong3() {
        // 将读取的little-endian编码的3个字节转化为长整型数
        $result = unpack('Vlong', fread($this->fp, 3) . chr(0));
        return $result['long'];
    } 

    function packip($ip) {
        // pack把数据装入一个二进制字符串
        // ip2long将IP地址转成无符号的长整型，也可以用来验证IP地址
        return pack('N', intval(ip2long($ip)));
    } 

    function getstring($data = "") {
        $char = fread($this->fp, 1);
        while (ord($char) > 0) { // ord返回字符的ASCII值，字符串按照C格式保存，以\0结束
            $data .= $char;
            $char = fread($this->fp, 1);
        } 
        return $data;
    } 

    function getarea() {
        $byte = fread($this->fp, 1); // 标志字节
        switch (ord($byte)) {
            case 0: // 没有区域信息
                $area = "";
                break;
            case 1:
            case 2: // 标志字节为1或2，表示区域信息被重定向
                fseek($this->fp, $this->getlong3());
                $area = $this->getstring();
                break;
            default: // 否则，表示区域信息没有被重定向
                $area = $this->getstring($byte);
                break;
        } 
        return $area;
    } 

    function getlocation($ip) {
        if (!$this->fp) return null; // 如果数据文件没有被正确打开，则直接返回空
        $location['ip'] = gethostbyname($ip); // 域名转化为IP地址
        $ip = $this->packip($location['ip']); // 将输入的IP地址转化为可比较的IP地址 
        // 不合法的IP地址会被转化为255
        // 对分搜索
        $l = 0; // 搜索的下边界
        $u = $this->totalip; // 搜索的上边界
        $findip = $this->lastip; // 如果没有找到就返回最后一条IP记录（QQWry.Dat的版本信息）
        while ($l <= $u) { // 当上边界小于下边界时，查找失败
            $i = floor(($l + $u) / 2); // 计算近似中间记录
            fseek($this->fp, $this->firstip + $i * 7);
            $beginip = strrev(fread($this->fp, 4)); // 获取中间记录的开始IP地址,strrev反转字符串 
            // strrev函数在这里的作用是将little-endian的压缩IP地址转化为big-endian的格式，便于比较
            // 关于little-endian与big-endian 参考：http://baike.baidu.com/view/2368412.htm
            if ($ip < $beginip) { // 用户的IP小于中间记录的开始IP地址时
                $u = $i - 1; // 将搜索的上边界修改为中间记录减一
            } else {
                fseek($this->fp, $this->getlong3());
                $endip = strrev(fread($this->fp, 4)); // 获取中间记录的结束IP地址
                if ($ip > $endip) { // 用户的IP大于中间记录的结束IP地址时
                    $l = $i + 1; // 将搜索的下边界修改为中间记录加一
                } else { // 用户的IP在中间记录的IP范围内时
                    $findip = $this->firstip + $i * 7;
                    break; // 则表示找到结果，退出循环
                } 
            } 
        } 

        fseek($this->fp, $findip);
        $location['beginip'] = long2ip($this->getlong()); // 用户IP所在范围的开始地址
        $offset = $this->getlong3();
        fseek($this->fp, $offset);
        $location['endip'] = long2ip($this->getlong()); // 用户IP所在范围的结束地址
        $byte = fread($this->fp, 1); // 标志字节
        switch (ord($byte)) {
            case 1: // 标志字节为1，表示国家和区域信息都被同时重定向
                $countryOffset = $this->getlong3(); // 重定向地址
                fseek($this->fp, $countryOffset);
                $byte = fread($this->fp, 1); // 标志字节
                switch (ord($byte)) {
                    case 2: // 标志字节为2，表示国家信息又被重定向
                        fseek($this->fp, $this->getlong3());
                        $location['country'] = $this->getstring();
                        fseek($this->fp, $countryOffset + 4);
                        $location['area'] = $this->getarea();
                        break;
                    default: // 否则，表示国家信息没有被重定向
                        $location['country'] = $this->getstring($byte);
                        $location['area'] = $this->getarea();
                        break;
                } 
                break;
            case 2: // 标志字节为2，表示国家信息被重定向
                fseek($this->fp, $this->getlong3());
                $location['country'] = $this->getstring();
                fseek($this->fp, $offset + 8);
                $location['area'] = $this->getarea();
                break;
            default: // 否则，表示国家信息没有被重定向
                $location['country'] = $this->getstring($byte);
                $location['area'] = $this->getarea();
                break;
        } 
        if ($location['country'] == " CZNET") { // CZNET表示没有有效信息
            $location['country'] = "未知";
        } 
        if ($location['area'] == " CZNET") {
            $location['area'] = "";
        } 
        return $location;
    } 
    /**
     * 构造函数，打开 QQWry.Dat 文件并初始化类中的信息
     */
    public function __construct($filename = "qqwry.dat") {
        $this->fp = 0;
        if (($this->fp = fopen(dirname(__FILE__) . '/' . $filename, 'rb')) !== false) {
            $this->firstip = $this->getlong();
            $this->lastip = $this->getlong();
            $this->totalip = ($this->lastip - $this->firstip) / 7;
        } 
    } 
    /**
     * 析构函数，用于在页面执行结束后自动关闭打开的文件
     */
    function __destruct() {
        if ($this->fp) {
            fclose($this->fp);
        } 
        $this->fp = 0;
    } 
} 

if (!isipv6($ip)) {
    $iplocation = new IpLocation();
    $location = $iplocation->getlocation($ip);
    $region = iconv("gbk", "utf-8",$location['country']);
    $isp = iconv("gbk", "utf-8",$location['area']);
    $obj = (Object)null;
    $obj->region = $region;
    if (!empty($region)) {
	    $obj->city = '，' ;
}
    if (!empty($isp)) {
	    $obj->isp = $isp;
    } else {
	    $obj->city = '' ;
	    $obj->isp = '' ;
    }

    $json['data'] = $obj;
    echo json_encode($json, JSON_UNESCAPED_UNICODE);
} else {
	echo query($ip);
}

function isipv6($s) { //硬核判断是否为ipv6地址
	return strpos($s, ":") !== false;
}
function query($ip) {
    $db6 = new ipdbv6("ipv6data/ipv6wry.db");
    $code = 0;
    try {
        if (isipv6($ip)) {
            $result = $db6->query($ip);
        }
    }
    catch (Exception $e) {
        $result = array("disp" => $e->getMessage());
        $code = -400;
    }

	$isp = $result["addr"][1];
	$region = $result["addr"][0];
    
    $obj = (Object)null;
    $obj->region = $region;
    if (!empty($region)) {
	    $obj->city = '，' ;
    }
    if (!empty($isp)) {
	    $obj->isp = $isp;
    } else {
	    $obj->city = '' ;
	    $obj->isp = '' ;
    }

    $json['data'] = $obj;
    echo json_encode($json, JSON_UNESCAPED_UNICODE);
}
?>