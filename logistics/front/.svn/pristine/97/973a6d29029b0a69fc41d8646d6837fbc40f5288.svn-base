<?php 
namespace chief725\libs;

use yii\console\Exception;


class Spider{
	public static function getContents($url,$retry=3, $fatal=true,$retryInterval=3,$isMobile=false,$opts=[]){
		Log::info("Retry: $retry");
		if ($retry == 0 ){
			if($fatal) {
				throw new Exception("Error downloading: $url");
			}else {
				Log::info("Error downloading: $url");
				if (!empty($http_response_header) && preg_match("/\d{3}/", $http_response_header[0],$matches)){
					return $matches[0];
				}else{
					return false;
				}
			}
		}

		$headers = [];
		if ($isMobile){
			$headers[] = "User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 5_0 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A334 Safari/7534.48.3";
		}else{
			$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.81 Safari/537.36";
		}
		$headers[] = "Cookie: foo=bar";
		$headers[] = "Referer: $url";
		$headers[] = "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8";
		$headers[] = "accept-language:zh,en-US;q=0.8,en;q=0.6,zh-CN;q=0.4,zh-TW;q=0.2,id;q=0.2";
		$headers[] = "Cache-Control:max-age=0";
		$headers[] = "Accept-Encoding:deflate,sdch";
		$options = array(
				'http' => array (
						'method' => "GET",
						'header' =>  join("\r\n", $headers)
				)
		);
		$options['http'] = array_merge($options['http'],$opts);
		$content = @file_get_contents ( $url, false, stream_context_create ( $options ) );
		if (!$content){
			Log::info(join(";", error_get_last()));
			sleep($retryInterval);
			return self::getContents($url,--$retry, $fatal,$retryInterval,$opts);
		}
		return $content;
	}
}