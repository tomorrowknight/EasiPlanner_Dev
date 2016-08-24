<?php

namespace app\controllers;

use app\models\Geocode;
use chief725\libs\__;
use yii\web\Controller;

class TutorialController extends Controller {
	public function actionSample($limit = 80) {
		$geocodes = Geocode::find ()->where ( "postal not like '9%'" )->orderBy ( "rand()" )->limit ( $limit )->all ();
		$csv = new \parseCSV ();
		$parcels = __::from ( $geocodes )->map ( function ($geocode) {
			$day = date ( "d" );
			$hour = 7 + rand ( 0, 12 );
			$hour_end = $hour + 3;
			$newParcel = [ 
					"identifier" => "SN" . rand ( 10000000, 99999999 ),
					"postal" => $geocode->postal,
					"volume" => 1,
					"weight" => 1,
					"service_time" => 15,
					"phone" => rand ( 90000000, 99999999 ),
					"customer_name" => "Customer " . rand ( 1, 1000 ),
					"window_start" => date ( "Y-m-d $hour:00:00" ),
					"window_end" => date ( "Y-m-d $hour_end:00:00" ),
					'lat' => $geocode->lat,
					'lng' => $geocode->lng 
			];
			
			return $newParcel;
		} );
		$csv->output ( "parcels.csv", $parcels, array_keys ( $parcels [0] ) );
	}
}
