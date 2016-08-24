<?

namespace chief725\libs;

use yii\helpers\Html;
use Yii;

class AdsManager {
	public $ads_index = 0;
	public static $CAN_SHOW_ADS = true;
	public $clientId;
	public $adsSlotId;
	public $adRegion;
	private function __construct() {
	}
	public static $adsManager;
	public static function getInstance() {
		if (empty ( self::$adsManager )) {
			self::$adsManager = new AdsManager ();
		}
		return self::$adsManager;
	}
	public static function getAds($params = [], $showAds = true, $divParams = []) {
		if (self::getInstance ()->ads_index >= self::getMaxAds () || ! self::$CAN_SHOW_ADS) {
			return;
		}
		if ($showAds) {
			$adsHtml = self::getInstance ()->getAdsInternal ( $params );
			
			if (! empty ( $params ['tip'] )) {
				$adsHtml = "<div class='adsTip'>sponsored ads</div>" . $adsHtml;
				$divParams ['class'] = 'adsDiv adsTipDiv';
			}
			
			$divParams = array_merge ( [ 
					"class" => "adsDiv",
					"id" => "ads" . self::getInstance ()->ads_index 
			], $divParams );
			return Html::tag ( "div", $adsHtml, $divParams );
		}
	}
	public static function getMaxAds() {
		$adsenseParams = Yii::$app->params ['adsense'];
		return isset ( $adsenseParams ['maxAds'] ) ? $adsenseParams ['maxAds'] : 5;
	}
	public function getAdsInternal($params) {
		if ($this->ads_index >= self::getMaxAds () || ! self::$CAN_SHOW_ADS) {
			return;
		}
		$this->ads_index ++;
		$adsenseParams = Yii::$app->params ['adsense'];
		
		$adSlotId = Utils::choose ( $params ['slotId'], $adsenseParams ["slotId"] );
		$clientId = Utils::choose ( $params ['clientId'], $adsenseParams ["clientId"] );
		$style = empty ( $params ['width'] ) ? "display:block" : "display:inline-block;width:{$params['width']}px;height:{$params['height']}px";
		$adFormat = empty ( $params ['width'] ) ? 'data-ad-format="auto"' : "";
		$adRegion = isset ( $params ['adRegion'] ) ? "data-ad-region='{$params['adRegion']}'" : "";
		$adsHtml = <<<EOT
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<ins class="adsbygoogle"
		     data-ad-slot="$adSlotId"
		     data-ad-client="$clientId"
		     style="$style"
		     $adFormat
		     $adRegion
		>
		</ins>
		<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
EOT;
		return $adsHtml;
	}
}
?>