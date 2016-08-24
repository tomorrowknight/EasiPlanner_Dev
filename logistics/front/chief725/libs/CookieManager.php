<? 
namespace chief725\libs;
use Yii;

class CookieManager {
	public static function getCookieArray($key){
		return explode("-", self::getCookie($key));
	}
	
	public static function addCookie($key,$id){
		$cookies = self::getCookieArray($key);
		array_unshift($cookies, $id);
		$cookies = array_slice($cookies, 0,48);
		self::setCookie($key, join("-", $cookies));
	}
	
	public static function setCookie($key,$value){
		setcookie($key,$value, time()+3600*24*30,"/");
	}
	
	public static function getCookie($key){
		return isset($_COOKIE[$key])?$_COOKIE[$key]:"";
	}
	
	public static function delCookie($key,$id){
		$cookies = self::getCookieArray($key);
		$cookies = array_diff($cookies, [$id]);
		setcookie($key,join("-", $cookies), time()+3600*24*30,"/");
	}
	
	public static function hasCookie($key,$id){
		$cookies = self::getCookieArray($key);
		return in_array($id, $cookies);
	}
}
?>