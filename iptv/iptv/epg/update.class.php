<?php
class Unzip
{
		public function unzip_gz($gz_file){
            $buffer_size = 4096; // read 4kb at a time
            $out_file_name = str_replace('.gz', '', $gz_file);
            $file = gzopen($gz_file, 'rb');
            $out_file = fopen($out_file_name, 'wb');
            $str='';
            while(!gzeof($file)) {
                fwrite($out_file, gzread($file, $buffer_size));
            }
            fclose($out_file);
            gzclose($file);
        }

}
class getFile
{
		public function get($url, $save_dir = '', $filename = '', $type = 0)
		{
				if (trim($url) == '')
				{
						return false;
				}
				if (trim($save_dir) == '')
				{
						$save_dir = './';
				}
				if (0 !== strrpos($save_dir, '/'))
				{
						$save_dir .= '/';
				}
				if (!file_exists($save_dir) && !mkdir($save_dir, 0777, true))
				{
						return false;
				}
				if ($type)
				{
						$ch = curl_init();
						$timeout = 30;
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
						curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
						$content = curl_exec($ch);
						curl_close($ch);
				}
				else
				{
						ob_start();
						readfile($url);
						$content = ob_get_contents();
						ob_end_clean();
				}
				$size = strlen($content);
				$fp2 = @fopen($save_dir . $filename, 'a');
				fwrite($fp2, $content);
				fclose($fp2);
				unset($content, $url);
				return array(
						'file_name' => $filename,
						'save_path' => $save_dir . $filename,
						'file_size' => $size);
		}
}
?>
