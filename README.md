# 清和iptv
>提取自矿神群晖IPTV并大改，添加缺失功能，修改系统存在的安全漏洞      
## Change log
#### 2025-9-18
- 改不动这个史了，归档，go重构了下，看这个吧 [go-iptv](https://github.com/wz1st/go-iptv)
#### 2025-9-5
- 修复了文件上传漏洞
- 修复了任意文件删除漏洞
- 添加定时更新外部列表
- 添加更改应用图标功能
- 添加自动重新编译功能
- 添加修改应用名称、包名、签名key功能
- 修改了系统图标、系统名称、系统版本
#### 2025-8-25
- 添加docker自动构建，添加armv7、arm64、386、amd64版本
#### 2025-8-22
- 修复了SQL注入漏洞
- 改为alpine+nginx+php-fpm+mariadb 精简镜像大小
## 安装
```
docker volume create iptv
docker pull v1st233/iptv:latest
docker run -d --name iptv_server -p <port>:80 -v iptv:/var/lib/mysql -e PROTOCOL=http<or https> -e IPTV_SER_ADDR=<your_host> -e IPTV_SER_PORT=<port> v1st233/iptv:latest
# username: admin
# password: password
```
或
```
git clone https://github.com/wz1st/iptv.git
cd iptv
docker build -f Dockerfile -t image_name:latest .
docker volume create iptv
docker run -d --name iptv_server -p <port>:80 -v iptv:/var/lib/mysql -e PROTOCOL=http<or https> -e IPTV_SER_ADDR=<your_host> -e IPTV_SER_PORT=<port> image_name:latest
``` 

## 小声哔哔
>本程序仅供学习交流使用，请勿用于商业用途，否则后果自负。     
>本程序不保证长期稳定运行，请自行备份。     
>源自己找，有问题自己解决。     
>仅仅为了少装点群晖插件才整了个docker版(可以保证docker可用)，不保证手动安装能一次过。      
>作者不承担任何法律责任。     
>作者不承担任何法律责任。     
>作者不承担任何法律责任。     
