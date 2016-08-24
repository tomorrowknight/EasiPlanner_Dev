<?php
class Config{
	public static function set($key,$value){
		Yii::app()->settings->set(DOMAIN, $key, $value, $toDatabase=true);
	}
	public static function get($key){
		return Yii::app()->settings->get(DOMAIN,$key);
	}

	static $app_name = "app_name";
	static $language = "language";

	//seo
	static $title = "title";
	static $keywords = "keywords";
	static $description = "description";
	
	static $footer_text = 'footer_text';
	
	static $enable_ads = "enable_ads";
	
	static $theme = "theme";
	
	static $cache_duration = "cache_duration";
	static $enable_prefetch = "enable_prefetch";
	static $enable_highlight = "enable_highlight";
	
	public static function isZh(){
		return self::get(self::$language)!='en';
	}
	public static function isEnable($key){
		$key = "enable_$key";
		return self::get($key) == "true";
	}
}