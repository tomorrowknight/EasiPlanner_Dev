<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Geocode;
use chief725\libs\Log;
use app\models\Parcel;
use chief725\libs\Utils;

class TestController extends Controller {
	public function actionMatrix($limit = 100) {
		$geocodes = Geocode::find ()->orderBy ( "rand()" )->limit ( $limit )->all ();
		$locs = array_map ( function ($geocode) {
			return "loc={$geocode->lat},{$geocode->lng}";
		}, $geocodes );
		$url = "http://dev.logistics.lol:5000/table?" . join ( "&", $locs );
		Log::info ( "Starting..." );
		$json = json_decode ( file_get_contents ( $url ) );
		Log::info ( count ( $json->distance_table ) );
	}
	public function actionMatrix2($ids) {
		$geocodes = Parcel::findAll ( explode ( ",", $ids ) );
		$locs = array_map ( function ($geocode) {
			Log::info("$geocode->lat,$geocode->lng");
			return "loc={$geocode->lat},{$geocode->lng}";
		}, $geocodes );
		$url = "http://dev.logistics.lol:5000/table?" . join ( "&", $locs );
		Log::info($url);
		$json = json_decode ( file_get_contents ( $url ) );
		Utils::print_d($json->distance_table );
	}
}
