<?php
/**
 * 本缓类用静态的方法编写，使用方法如下：
 * Cache::$cache_path  设置缓存目录  注：目录的格式如下：cache/ 目录名称前一定要加上"/"斜杠，否则，将会成默认目录
 * Cache::$cache_expire  设置缓存时间
 * Cache::put($key,$data)  写入缓存，其中$key为缓存的ID,$data为缓存内容
 * Cache::get($key);  读取缓存内容，其中$key为缓存ID
 * Cache::gets($key);  读取不受缓存时间限制的内容，其中$key为缓存ID
 * Cache::dels($key);  删除当前缓存目录下指定或是全部缓存文件，其中$key参数为空删除当前目录下所有缓存文件，反之，删除指定的缓存文件
 */
class Cache {
    static $cache_path = "cache/"; //path for the cache
    static $cache_expire = 3600; //seconds that the cache expires 
    // returns the filename for the cache
    private static function fileName($key) {
        return self::$cache_path . md5($key);
    } 
    // creates new cache files with the given data, $key== name of the cache, data the info/values to store
    public static function put($key, $data) {
        if (!is_dir(self::$cache_path)) {
            mkdir(self::$cache_path, 0777, true);
        } 
        if (empty($data)) {
            return false;
        } 
        $values = serialize($data);
        $filename = self::fileName($key);
        $file = fopen($filename, 'w');
        if ($file && !empty($data)) { // able to create the file
            fwrite($file, $values);
            fclose($file);
        } else return false;
    } 
    // 文件缓存时间
    public static function get_file_time($key) {
        $filename = self::fileName($key);
        if (!file_exists($filename) || !is_readable($filename)) { // can't read the cache
            return false;
        } 
        return (time() - filemtime($filename));
    } 
    // returns cache for the given key
    public static function get($key) {
        $filename = self::fileName($key);
        if (!file_exists($filename) || !is_readable($filename)) { // can't read the cache
            return false;
        } 
        if (time() < (filemtime($filename) + self::$cache_expire)) { // cache for the key not expired
            $file = fopen($filename, "r"); // read data file
            if ($file) { // able to open the file
                $data = fread($file, filesize($filename));
                fclose($file);
                return unserialize($data); //return the values
            } else return false;
        } else return false; //was expired you need to create new
    } 
    // 单独获取一个文件，不受缓存时间限制
    public static function gets($key) {
        $filename = self::fileName($key);
        if (!file_exists($filename) || !is_readable($filename)) { // can't read the cache
            return false;
        } 
        $file = fopen($filename, "r"); // read data file
        if ($file) { // able to open the file
            $data = fread($file, filesize($filename));
            fclose($file);
            return unserialize($data); //return the values
        } else return false;
    } 
    // 删除指定目录单个缓存或是当前目录下的所有缓存文件
    public static function dels($key = "") {
        if (!empty($key)) {
            @unlink(self::fileName($key));
        } else {
            $dirs = glob(self::$cache_path . "*"); //获取当前目录所有文件
            @array_map('unlink', $dirs); //删除当前目录所有文件
        } 
    } 
} 

?>