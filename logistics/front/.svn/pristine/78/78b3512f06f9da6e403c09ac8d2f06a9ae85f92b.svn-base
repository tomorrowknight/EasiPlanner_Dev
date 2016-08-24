<?php

namespace app\libs;

class GoogleService {
	public $key;
	public $client;
	public function __construct($key, $client) {
		$this->key = $key;
		$this->client = $client;
	}
	public function signurl($my_url_to_sign) {
		$my_url_to_sign .= "&client=$this->client";
		$url = parse_url ( $my_url_to_sign );
		$signature = hash_hmac ( "sha1", $url ['path'] . "?" . $url ['query'], self::decodeBase64UrlSafe ( $this->key ), true );
		return $my_url_to_sign . "&signature=" . self::encodeBase64UrlSafe ( $signature );
	}
	public static function encodeBase64UrlSafe($value) {
		return str_replace ( array (
				'+',
				'/' 
		), array (
				'-',
				'_' 
		), base64_encode ( $value ) );
	}
	public static function decodeBase64UrlSafe($value) {
		return base64_decode ( str_replace ( array (
				'-',
				'_' 
		), array (
				'+',
				'/' 
		), $value ) );
	}
	public static function getLocalTime($hour, $zone) {
		return strtotime ( 'tomorrow' ) + $hour * 3600 - $zone * 3600;
	}
}