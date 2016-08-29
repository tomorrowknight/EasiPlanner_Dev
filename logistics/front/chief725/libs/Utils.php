<?

namespace chief725\libs;

use Yii;
use yii\helpers\Html;

class Utils {
	public static function header_expire($interval) {
		header ( "Cache-Control: max-age=$interval" );
		header ( "Pragma: public" );
		header ( 'Expires: ' . gmdate ( 'D, d M Y H:i:s', time () + $interval ) . ' GMT' );
	}
	public static function header_last_modified($last_modified_time) {
		header ( "Last-Modified: " . gmdate ( "D, d M Y H:i:s", $last_modified_time ) . " GMT" );
	}
	public static function cutString($string, $length) {
		if (mb_strlen ( $string, 'utf8' ) <= $length) {
			return $string;
		} else {
			return mb_substr ( $string, 0, $length, 'utf8' ) . " ...";
		}
	}
	public static function queryString($key, $default = "") {
		if (! empty ( $_POST [$key] ))
			return $_POST [$key];
		if (! empty ( $_GET [$key] ))
			return $_GET [$key];
		return $default;
	}
	public static function select($obj1, $obj2) {
		return empty ( $obj1 ) ? $obj2 : $obj1;
	}
	public static function choose(&$obj1, $obj2) {
		return empty ( $obj1 ) ? $obj2 : $obj1;
	}
	public static function from($country_code) {
		if (isset ( $_SERVER ["HTTP_CF_IPCOUNTRY"] ) && ! empty ( $country_code )) {
			$cf_country_code = strtolower ( $_SERVER ["HTTP_CF_IPCOUNTRY"] );
			$country_codes = explode ( ",", $country_code );
			return in_array ( $cf_country_code, $country_codes );
		}
		return false;
	}
	public static function icon($icon) {
		return "<i class='glyphicon glyphicon-$icon'></i> ";
	}
	public static function iconfa($icon) {
		return "<i class='fa fa-$icon'></i> ";
	}
	public static function in($stack, $needle) {
		return strpos ( $stack, $needle ) !== false;
	}
	public static function isAdmin() {
		return ! Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin ();
	}
	public static function isEditor() {
		return ! Yii::$app->user->isGuest && Yii::$app->user->identity->isEditor ();
	}
	public static function isGuest() {
		return Yii::$app->user->isGuest;
	}
	public static function print_d($arr) {
		echo "<pre>";
		print_r ( $arr );
		echo "</pre>";
	}
	public static function now() {
		return date ( "Y-m-d H:i:s" );
	}
	public static function similar($str1, $str2) {
		similar_text ( $str1, $str2, $percent );
		return $percent;
	}
	public static function ipLink($ip) {
		return Html::a ( $ip, "http://www.iplocation.net?query=$ip" );
	}
	public static function lessThan($num) {
		return rand ( 0, 100 ) < $num;
	}
	public static function genAPI() {
    		$alphabet = 'QlmHhaO14wyXBD0RgtEvcIfdn2jb3A8UsLN5xoGPqZM6kKJVr9iYS7TCWzFpue';
    		$pass = array(); //remember to declare $pass as an array
    		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    		for ($i = 0; $i < 24; $i++) {
        		$n = mt_rand(0, $alphaLength);
        		$pass[] = $alphabet[$n];
    		}
    		return implode($pass); //turn the array into a string
	}	
}
?>
