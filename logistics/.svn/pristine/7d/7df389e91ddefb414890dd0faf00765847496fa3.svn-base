<?php
namespace app\commands;

use app\models\Weather;

use yii\helpers\Url;
use app\models\Incident;
use chief725\libs\Log;
use Yii;
use yii\console\Controller;

class CrawlerController extends Controller
{
	/**
	 * This command echoes what you have entered as the message.
	 * @param string $message the message to be echoed.
	 */
	
	public function actionClear(){
		Log::info("Clear databases");
		Yii::$app->db->createCommand('truncate incident;truncate roadwork;truncate traveltime')->execute();
	}
	
	public function actionIndex(){
		$this->crawlLTAData("Incident", Url::to("@webroot/simulate/IncidentSet.xml"));
		$this->crawlLTAData("Roadwork", Url::to("@webroot/simulate/RoadWorkSet.xml"));
		$this->crawlLTAData("Traveltime", Url::to("@webroot/simulate/TravelTimeSet.xml"));
		$this->crawlWeatherData();
	}
	
	private function crawlLTAData($clazz,$url){
		Log::info("Start crawling $url");
		$clazz = "app\\models\\$clazz";
		$XmlString = preg_replace("#<(/?)(m:|d:|geo:)#", "<$1", file_get_contents($url));
		$Xml = simplexml_load_string($XmlString);
		foreach ($Xml->entry as $entry){
			sleep(1);
			$data =  $entry->content->properties;
			$model = new $clazz;
			foreach ($model->activeAttributes() as $attr){
				$model->$attr =(string) $data->$attr;
			}
			if($model->validate()){
				if(!$model->save()){
					print_r($model->getErrors());
					exit;
				}else{
					print_r($model->attributes);
				}
			}else{
				print_r($model->getErrors());
			}
		}
	}
	
	private function crawlWeatherData(){
		$url = "http://www.weather.gov.sg/wip/pp/rndops/web/rss/rssNcast_NEW.xml";
		$Xml = simplexml_load_string(file_get_contents($url));
		$html =(string)($Xml->entry->summary);
		$html = preg_replace("#<b>.*</b>#", "", $html);
		$locations = explode("<br/>", $html);
		foreach ($locations as $location){
			sleep(1);
			$location = trim($location);
			if (empty($location)) continue;
			list($area,$description) = explode("-", $location);
			
			$weather = new Weather;
			$weather->area = $area;
			$weather->description = $description;
			$weather->created = date("Y-m-d H:i:s");
			if($weather->save()){
				Log::info($area);
			}else{
				print_r($area->getErrors());
			}
		}
	}
}
