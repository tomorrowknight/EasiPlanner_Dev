<?php
namespace chief725\libs;
use GoogleMapsGeocoder;

class GoogleMap{
	public function getLatLng($address,$region=null){
		$geocoder = new GoogleMapsGeocoder("$address");
		$geocoder->setRegion($region);
		$response = $geocoder->geocode();
		if (empty($response['results'])){
			return null;
		}else{
			return $response['results'][0]['geometry']['location'];
		}
	}
}