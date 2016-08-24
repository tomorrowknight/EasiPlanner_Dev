<?php

namespace app\commands;

use app\models\Parcel;
use chief725\libs\Log;
use yii\console\Controller;

class CollectController extends Controller {
	public function actionLatlng() {
		$parcels = Parcel::find ()->where ( [ 
				"lat" => null 
		] )->limit ( 1000 );
		foreach ( $parcels->each () as $parcel ) {
			$parcel->updateLatLng ();
			Log::info ( "Solving Postal $parcel->postal: $parcel->lat - $parcel->lng" );
		}
	}
}
