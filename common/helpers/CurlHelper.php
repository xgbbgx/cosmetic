<?php 
namespace common\helpers;
class CurlHelper{
	/**
	 * [query curl访问]
	 * @param  [type]  $url             [地址]
	 * @param  array   $arr_query       [访问参数]
	 * @param  string  $method          [get/post]
	 * @param  string  $connect_timeout [链接时间]
	 * @param  string  $read_timeout    [读取时间]
	 * @param  boolean $isJson          [是否返回json]
	 * @return [type]                   [description]
	 */
	public static function query($url, $arr_query = array(), $method = 'get',$connect_timeout='5000',$read_timeout = "5000",$isJson=true){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if (strtolower($method) == 'post') {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arr_query));
		} else {
		    if($arr_query){
			 $and = strpos($url, '?') === false?'?':'&';
			 $url .= $and. http_build_query($arr_query);
		    }
		}
		curl_setopt($ch, CURLOPT_URL, $url);

		$version = curl_version();
		if (version_compare($version['version'], '7.16.2') < 0) {
			$connect_timeout = floor($connect_timeout / 1000);
			if($connect_timeout <= 0){
				$connect_timeout = 1;
			}
			$read_timeout = floor($read_timeout / 1000);
			if($read_timeout <= 0){
				$read_timeout = 3;
			}
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connect_timeout);
			curl_setopt($ch, CURLOPT_TIMEOUT, $read_timeout);
		} else {
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $connect_timeout);
			curl_setopt($ch, CURLOPT_TIMEOUT_MS, $read_timeout);
		}
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 3);
		$result = curl_exec($ch);
		$curl_errno = curl_errno($ch);
		$curl_error = curl_error($ch);
		curl_close($ch);
		if ($curl_errno != 0) {
			return false;
		}
		if($isJson){
			$result=json_decode(@$result, true);
		}
		return $result;
	}
	
	/**
	 * [query curl访问]
	 * @param  [type]  $url             [地址]
	 * @param  array   $arr_query       [访问参数]
	 * @param  string  $method          [get/post]
	 * @param  string  $connect_timeout [链接时间]
	 * @param  string  $read_timeout    [读取时间]
	 * @param  boolean $isJson          [是否返回json]
	 * @return [type]                   [description]
	 */
	public static function spiderQuery($url, $arr_query = array(), $method = 'get',$connect_timeout='5000',$read_timeout = "5000"){
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    if (strtolower($method) == 'post') {
	        curl_setopt($ch, CURLOPT_POST, true);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arr_query));
	    } else {
	        if($arr_query){
	            $and = strpos($url, '?') === false?'?':'&';
	            $url .= $and. http_build_query($arr_query);
	        }
	    }
	    curl_setopt($ch, CURLOPT_URL, $url);
	    
	    $version = curl_version();
	    if (version_compare($version['version'], '7.16.2') < 0) {
	        $connect_timeout = floor($connect_timeout / 1000);
	        if($connect_timeout <= 0){
	            $connect_timeout = 1;
	        }
	        $read_timeout = floor($read_timeout / 1000);
	        if($read_timeout <= 0){
	            $read_timeout = 3;
	        }
	        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connect_timeout);
	        curl_setopt($ch, CURLOPT_TIMEOUT, $read_timeout);
	    } else {
	        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $connect_timeout);
	        curl_setopt($ch, CURLOPT_TIMEOUT_MS, $read_timeout);
	    }
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 3);
	    $result = curl_exec($ch);
	    $curl_errno = curl_errno($ch);
	    $curl_error = curl_error($ch);
	    curl_close($ch);
	    if ($curl_errno != 0) {
	        return false;
	    }
	    return $result;
	}
}

?>