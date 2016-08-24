<?php

namespace app\commands;

use chief725\libs\Log;
use yii\console\Controller;
use app\models\Geocode;

class TestController extends Controller {
	public function actionMatrix($limit = 100) {
		$geocodes = Geocode::find ()->orderBy ( "rand()" )->limit ( $limit )->all ();
		$locs = array_map ( function ($geocode) {
			return "loc={$geocode->lat},{$geocode->lng}";
		}, $geocodes );
		$url = "http://dev.logistics.lol:5000/table?" . join ( "&", $locs );
		$response = json_decode(file_get_contents($url));
		Log::info("Count: ".count($response->distance_table));
	}

	public function actionSpeed($loop=100){
		foreach(range(1,$loop) as $i){
			$this->actionMatrix(800);
		}
	}
}
