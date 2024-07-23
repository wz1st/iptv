# iptv
>提取自矿神群晖iptv      
## 安装
### docker版
```
docker pull v1st233/iptv:latest
docker run -d --name iptv_server -p <port>:80 -v /<path>:/var/lib/mysql -e PROTOCOL=http<or https> -e IPTV_SER_ADDR=<your_host> -e IPTV_SER_PORT=<port> v1st233/iptv:latest
# username: admin
# password: password
```
### 手动版
#### 安装jdk 8
```略```
#### 安装nginx or apache
```略```
#### 安装PHP 8
```
#安装启用扩展
ctype
curl
dom
fileinfo
filter
ftp
gd
iconv
intl
mbstring
mysqli
mysqlnd
openssl
PDO
pdo_mysql
pdo_sqlite
Phar
posix
readline
SimpleXML
sockets
sodium
sqlite3
tokenizer
xml
xmlreader
xmlwriter
```
#### 安装mysql
```略```
#### 下载源码
```
git clone https://github.com/wz1st/iptv.git
cd iptv
```
#### 导入数据
```
mysql -u<user> -p<pwd>  iptv < database/iptv.sql
```
#### 启用web
```
cp -r iptv/* /var/www/html/
```
#### 修改配置
```
#/var/www/html/iptv/config.php
$this->host = 'localhost'; //数据库服务器
$this->port = '3306'; //数据库端口
$this->user = 'root'; //数据库帐号
$this->pass = 'root'; //数据库密码
```         
```
cp -rf apktool /use/local/apktool
cp -rf client /use/local/client
cp -rf buildapk.sh /use/local/buildapk.sh
```
## 使用
```
#非docker版
/use/local/buildapk.sh http <ip> <port>
http://ip:port
```

## 小声哔哔
>本程序仅供学习交流使用，请勿用于商业用途，否则后果自负。     
>本程序不保证长期稳定运行，请自行备份。     
>源自己找，有问题自己解决。     
>仅仅为了少装点群晖插件才整了个docker版(可以保证docker可用)，不保证手动安装能一次过。      
>作者不承担任何法律责任。     
>作者不承担任何法律责任。     
>作者不承担任何法律责任。     