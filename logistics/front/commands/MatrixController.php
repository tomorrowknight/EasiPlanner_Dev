<?php

namespace app\commands;

use app\libs\GoogleService;
use app\models\Geocode;
use app\models\MatrixPostal;
use chief725\libs\Log;
use Yii;
use yii\console\Controller;
use chief725\models\Node;

class MatrixController extends Controller {
	const GOOGLE_CLIENT = "gme-republicpolytechnic";
	const GOOGLE_KEY = "nJxJLqiWuL68EBCc_nPpepmGmKE=";
	const COLLECT_HOURS = "3,8,15,18";
	const PARCELS_PER_ZONE = 10;
	const COLLECT_HOURS = "8,15,18";
	// const COLLECT_HOURS = "18";
	const PARCELS_PER_ZONE = 100;
	public function actionPopulate() {
		MatrixPostal::deleteAll ();
		foreach ( MatrixPostal::zoneMapping () as $zone => $prefixs ) {
			Log::info ( "Zone: $zone" );
			$query = Geocode::find ()->limit ( self::PARCELS_PER_ZONE )->orderBy ( "rand()" );
			foreach ( $prefixs as $prefix ) {
				$query->orWhere ( "postal like '$prefix%'" );
			}
			foreach ( $query->each () as $geocode ) {
				$matrixPostal = new MatrixPostal ();
				$matrixPostal->start = $geocode->postal;
				$matrixPostal->start_lat = $geocode->lat;
				$matrixPostal->start_lng = $geocode->lng;
				$matrixPostal->save ();
				Log::info ( "Inserting $geocode->postal" );
			}
		}
		$matrixPostals1 = MatrixPostal::find ()->select ( [ 
				'start',
				'start_lat',
				'start_lng' 
		] )->all ();
		$matrixPostals2 = MatrixPostal::find ()->select ( [ 
				'start',
				'start_lat',
				'start_lng' 
		] )->all ();
		foreach ( explode ( ",", self::COLLECT_HOURS ) as $time ) {
			foreach ( $matrixPostals1 as $matrixPostal1 ) {
				Log::info ( "Processing $matrixPostal1->start" );
				foreach ( $matrixPostals2 as $matrixPostal2 ) {
					$matrixPostal = new MatrixPostal ();
					$matrixPostal->time = $time;
					$matrixPostal->start = $matrixPostal1->start;
					$matrixPostal->start_lat = $matrixPostal1->start_lat;
					$matrixPostal->start_lng = $matrixPostal1->start_lng;
					
					$matrixPostal->end = $matrixPostal2->start;
					$matrixPostal->end_lat = $matrixPostal2->start_lat;
					$matrixPostal->end_lng = $matrixPostal2->start_lng;
					$matrixPostal->save ();
				}
			}
		}
	}
	public function actionPopulate2() {
		MatrixPostal::deleteAll ();
		$zoneMapping = MatrixPostal::zoneMapping ();
		foreach ( [ 
				1 => 2,
				0 => 27 
		] as $startZone => $endZone ) {
			$startQuery = Geocode::find ()->limit ( self::PARCELS_PER_ZONE )->orderBy ( "rand()" );
			foreach ( $zoneMapping [$startZone] as $prefix ) {
				$startQuery->orWhere ( "postal like '$prefix%'" );
			}
			$startPostals = $startQuery->all ();
			
			$endQuery = Geocode::find ()->limit ( self::PARCELS_PER_ZONE )->orderBy ( "rand()" );
			foreach ( $zoneMapping [$endZone] as $prefix ) {
				$endQuery->orWhere ( "postal like '$prefix%'" );
			}
			$endPostals = $endQuery->all ();
			
			foreach ( explode ( ",", self::COLLECT_HOURS ) as $time ) {
				foreach ( $startPostals as $index => $startPostal ) {
					Log::info ( "$index" );
					foreach ( $endPostals as $endPostal ) {
						$matrixPostal = new MatrixPostal ();
						$matrixPostal->time = $time;
						$matrixPostal->start = $startPostal->postal;
						$matrixPostal->start_lat = $startPostal->lat;
						$matrixPostal->start_lng = $startPostal->lng;
						
						$matrixPostal->end = $endPostal->postal;
						$matrixPostal->end_lat = $endPostal->lat;
						$matrixPostal->end_lng = $endPostal->lng;
						$matrixPostal->save ();
					}
				}
			}
		}
	}
	public function actionCollect() {
		$googleService = new GoogleService ( self::GOOGLE_KEY, self::GOOGLE_CLIENT );
		while ( true ) {
			$postals = MatrixPostal::find ()->select ( "start,start_lat,start_lng" )->where ( "`time` IS NOT NULL AND `duration` IS NULL" )->distinct ()->all ();
			if (empty ( $postals ))
				break;
			foreach ( explode ( ",", self::COLLECT_HOURS ) as $time ) {
				$departure_time = GoogleService::getLocalTime ( $time, 8 );
				foreach ( $postals as $postal ) {
					$matrixPostals = MatrixPostal::find ()->where ( [ 
							'start' => $postal->start,
							'time' => $time 
					] )->andWhere ( "`end` IS NOT NULL AND `duration` IS NULL" )->limit ( 100 )->all ();
					if (empty ( $matrixPostals ))
						continue;
					$destinations = array_map ( function ($m) {
						return "$m->end_lat,$m->end_lng";
					}, $matrixPostals );
					$destinations = join ( "|", $destinations );
					$url = "https://maps.googleapis.com/maps/api/distancematrix/json?departure_time={$departure_time}&origins={$postal->start_lat},{$postal->start_lng}&destinations={$destinations}";
					$url = $googleService->signurl ( $url );
					$res = json_decode ( file_get_contents ( $url ) );
					echo $url;
					print_r ( $res );
					foreach ( $res->rows [0]->elements as $index => $item ) {
						$matrixPostal = $matrixPostals [$index];
						$matrixPostal->duration = $item->duration->value;
						$matrixPostal->duration_in_traffic = isset ( $item->duration_in_traffic->value ) ? $item->duration_in_traffic->value : $matrixPostal->duration;
						$matrixPostal->distance = $item->distance->value;
						$matrixPostal->speed = $matrixPostal->duration == 0 ? 1 : $matrixPostal->distance / $matrixPostal->duration_in_traffic;
						if (! $matrixPostal->save ()) {
							print_r ( $matrixPostal->getErrors () );
							exit ();
						}
					}
					usleep ( 1000 * 100 );
				}
			}
		}
	}
	public function actionTest($start = 238356, $end = 576147, $hours = self::COLLECT_HOURS) {
		$googleService = new GoogleService ( self::GOOGLE_KEY, self::GOOGLE_CLIENT );
		$start = Geocode::findGeocode ( $start );
		$end = Geocode::findGeocode ( $end );
		foreach ( explode ( ",", $hours ) as $time ) {
			Log::info ( "Hour: $time" );
			$departure_time = GoogleService::getLocalTime ( $time, 8 );
			$url = "https://maps.googleapis.com/maps/api/distancematrix/json?departure_time={$departure_time}&origins={$start->lat},{$start->lng}&destinations={$end->lat},{$end->lng}";
			$url = $googleService->signurl ( $url );
			$res = json_decode ( file_get_contents ( $url ) );
			echo $url;
			print_r ( $res );
		}
	}
	public function actionVerify($sample_size) {
		$googleService = new GoogleService ( self::GOOGLE_KEY, self::GOOGLE_CLIENT );
		$records = [ ];
		$lines = [ 
				"is_same_zone,start_zone,end_zone,time,duration_in_traffic,distance,speed,duration_cal" 
		];
		foreach ( range ( 1, $sample_size ) as $i ) {
			$start = Geocode::find ()->orderBy ( "rand()" )->andWhere ( "postal not like '9%'" )->one ();
			$end = Geocode::find ()->where ( "id!=$start->id" )->andWhere ( "postal not like '9%'" )->orderBy ( "rand()" )->one ();
			$times = explode ( ",", self::COLLECT_HOURS );
			$time = $times [rand ( 0, count ( $times ) - 1 )];
			$speed = MatrixPostal::getSpeed ( $start->postal, $end->postal, $time );
			Log::info ( "$i : $start->postal, $end->postal : $speed" );
			if ($speed == 0)
				continue;
			$departure_time = GoogleService::getLocalTime ( $time, 8 );
			$url = "https://maps.googleapis.com/maps/api/distancematrix/json?departure_time={$departure_time}&origins={$start->lat},{$start->lng}&destinations={$end->lat},{$end->lng}";
			$url = $googleService->signurl ( $url );
			$res = json_decode ( file_get_contents ( $url ) );
			$distance = $res->rows [0]->elements [0]->distance->value;
			$duration_in_traffic = $res->rows [0]->elements [0]->duration_in_traffic->value;
			$duration_cal = $distance / $speed;
			$diff = $duration_cal - $duration_in_traffic;
			Log::info ( "From:$start->postal To:$end->postal $time:00 \t $distance / $speed = $duration_cal  - $duration_in_traffic = $diff" );
			$records [] = [ 
					'time' => $time,
					"duration_in_traffic" => $duration_in_traffic,
					"distance" => $distance,
					"speed" => $speed,
					"duration_cal" => $duration_cal,
					"diff" => $diff 
			];
			
			$start_zone = MatrixPostal::getZone ( $start->postal );
			$end_zone = MatrixPostal::getZone ( $end->postal );
			$sameZone = $start_zone == $end_zone ? "yes" : "no";
			$lines [] = "$sameZone,$start_zone,$end_zone,$time,$duration_in_traffic,$distance,$speed,$duration_cal";
		}
		print_r ( $records );
		$totalDiff = 0;
		foreach ( $records as $record ) {
			$totalDiff += $record ['diff'];
		}
		
		$totalDuration = 0;
		foreach ( $records as $record ) {
			$totalDuration += $record ['duration_in_traffic'];
		}
		$diff_percent = $totalDiff / ($totalDuration + 0.00001);
		Log::info ( "Overall diff: $diff_percent" );
		file_put_contents ( Yii::getAlias ( "@webroot/verify.csv" ), join ( "\n", $lines ) );
	}
	public function actionFactor2() {
		MatrixPostal::updateAll ( [ 
				"factor" => 1 
		], [ 
				'time' => 3 
		] );
		$postals = MatrixPostal::find ()->where ( "factor IS  NULL AND `duration` IS NOT NULL" )->orderBy ( "id asc" );
		foreach ( $postals->each () as $postal ) {
			Log::info ( "Calculating Factor $postal->id" );
			$postal_free = MatrixPostal::find ()->where ( [ 
					'start' => $postal->start,
					'end' => $postal->end,
					'time' => 3 
			] )->one ();
			if (! empty ( $postal_free )) {
				$factor = $postal_free->duration_in_traffic == 0 ? 1 : $postal->duration_in_traffic / $postal_free->duration_in_traffic;
				Log::info ( "$postal->duration_in_traffic / $postal_free->duration_in_traffic = $factor" );
				$postal->factor = $factor;
				if (! $postal->save ()) {
					print_r ( $postal->getErrors () );
				}
			} else {
				Log::info ( "Not exists!" );
			}
		}
	}
	public function actionSpeed() {
		$speeds = [ ];
		$lines = [ 
				"hour,start_zone,end_zone,sample size,speed,diff(%)" 
		];
		foreach ( explode ( ",", self::COLLECT_HOURS ) as $time ) {
			$speeds [$time] = [ ];
			Log::info ( "################# $time ###################" );
			foreach ( MatrixPostal::zoneMapping () as $start_zone => $prefixs ) {
				Log::info ( "################# $time : $start_zone ###################" );
				$speeds [$time] [$start_zone] = [ ];
				foreach ( MatrixPostal::zoneMapping () as $end_zone => $prefixs ) {
					$speeds [$time] [$start_zone] [$end_zone] = [ ];
					foreach ( range ( self::PARCELS_PER_ZONE, 5, 5 ) as $selected_num ) {
						Log::info ( "################# $time : $start_zone -> $end_zone @ $time ###################" );
						$postals = MatrixPostal::find ()->where ( [ 
								'time' => $time,
								'start_zone' => $start_zone,
								'end_zone' => $end_zone 
						] )->orderBy ( "rand()" )->limit ( $selected_num * $selected_num )->all ();
						if (empty ( $postals ))
							continue;
						$totalSpeed = 0;
						foreach ( $postals as $postal ) {
							$totalSpeed += $postal->speed;
						}
						$speed = $totalSpeed / count ( $postals );
						$speeds [$time] [$start_zone] [$end_zone] [$selected_num] = $speed;
						$avgSpeed = $speeds [$time] [$start_zone] [$end_zone] [self::PARCELS_PER_ZONE];
						$diff = ($speed - $avgSpeed) / ($avgSpeed + 0.0001) * 100;
						$lines [] = "$time,$start_zone,$end_zone,$selected_num,$speed,$diff%";
					}
				}
			}
		}
		file_put_contents ( Yii::getAlias ( "@webroot/speed.csv" ), join ( "\n", $lines ) );
		print_r ( $speeds );
	}
	public function actionSpeed2() {
		$speeds = [ ];
		$lines = [ 
				"hour,start_zone,end_zone,sample size,speed,diff(%)" 
		];
		foreach ( explode ( ",", self::COLLECT_HOURS ) as $time ) {
			$speeds [$time] = [ ];
			Log::info ( "################# $time ###################" );
			foreach ( [ 
					1 => 2,
					0 => 27 
			] as $start_zone => $end_zone ) {
				foreach ( range ( self::PARCELS_PER_ZONE, 5, 5 ) as $selected_num ) {
					Log::info ( "################# $time : $start_zone -> $end_zone @ $time ###################" );
					$postals = MatrixPostal::find ()->where ( [ 
							'time' => $time,
							'start_zone' => $start_zone,
							'end_zone' => $end_zone 
					] )->orderBy ( "rand()" )->limit ( $selected_num * $selected_num )->all ();
					$totalSpeed = 0;
					foreach ( $postals as $postal ) {
						$totalSpeed += $postal->speed;
					}
					$speed = $totalSpeed / count ( $postals );
					$speeds [$time] [$start_zone] [$end_zone] [$selected_num] = $speed;
					$avgSpeed = $speeds [$time] [$start_zone] [$end_zone] [self::PARCELS_PER_ZONE];
					$diff = ($speed - $avgSpeed) / ($avgSpeed + 0.0001) * 100;
					$lines [] = "$time,$start_zone,$end_zone,$selected_num,$speed,$diff%";
				}
			}
		}
		file_put_contents ( Yii::getAlias ( "@webroot/speed2.csv" ), join ( "\n", $lines ) );
		print_r ( $speeds );
	}
	public function actionSpeeds() {
		$speeds = [ ];
		$lines = [ 
				"hour,start_zone,end_zone,speed" 
		];
		foreach ( explode ( ",", self::COLLECT_HOURS ) as $time ) {
			$speeds [$time] = [ ];
			Log::info ( "################# $time ###################" );
			foreach ( MatrixPostal::zoneMapping () as $start_zone => $prefixs ) {
				$speeds [$time] [$start_zone] = [ ];
				foreach ( MatrixPostal::zoneMapping () as $end_zone => $prefixs ) {
					$speed = MatrixPostal::find ()->where ( [ 
							'time' => $time,
							'start_zone' => $start_zone,
							'end_zone' => $end_zone 
					] )->orderBy ( "rand()" )->average ( "speed" );
					$speed = number_format ( $speed, 2 );
					$speeds [$time] [$start_zone] [$end_zone] = $speed;
					$lines [] = "$time,$start_zone,$end_zone,$speed";
				}
			}
		}
		file_put_contents ( Yii::getAlias ( "@webroot/speeds.json" ), json_encode ( $speeds ) );
		file_put_contents ( Yii::getAlias ( "@webroot/speeds.csv" ), join ( "\n", $lines ) );
		print_r ( $speeds );
	}
	public function actionZone() {
		$mapping = MatrixPostal::zoneMapping ();
		$mapping2 = [ ];
		foreach ( $mapping as $zone => $prefixs ) {
			foreach ( $prefixs as $prefix )
				$mapping2 [$prefix] = $zone;
		}
		print_r ( $mapping2 );
		file_put_contents ( Yii::getAlias ( "@webroot/zone.json" ), json_encode ( $mapping2 ) );
	}
	public function actionUpdateZone() {
		ini_set ( 'memory_limit', '-1' );
		$mapping = MatrixPostal::zoneMappingReverse ();
		foreach ( MatrixPostal::find ()->each ( 10 ) as $matrixPostal ) {
			if (strlen($matrixPostal->start_zone) <=2)
				continue;
			Log::info ( "updating $matrixPostal->id" );
			if (empty ( $mapping [substr ( $matrixPostal->start, 0, 2 )] ) || empty ( $mapping [substr ( $matrixPostal->end, 0, 2 )] )) {
				$matrixPostal->delete ();
			} else {
				$matrixPostal->start_zone = $mapping [substr ( $matrixPostal->start, 0, 2 )];
				if (! empty ( $matrixPostal->end )) {
					$matrixPostal->end_zone = $mapping [substr ( $matrixPostal->end, 0, 2 )];
				}
				$matrixPostal->save ();
			}
		}
	}
	public function actionFill() {
		$speeds = json_decode ( file_get_contents ( Yii::getAlias ( "@webroot/speeds.json" ) ) );
		foreach ( $speeds as $time => $speeds2 ) {
			foreach ( $speeds2 as $start_zone => $speeds3 ) {
				Log::info ( "update $time: $start_zone" );
				foreach ( $speeds3 as $end_zone => $speed ) {
					MatrixPostal::updateAll ( [ 
							"speed_avg" => $speed 
					], [ 
							'time' => $time,
							'start_zone' => $start_zone,
							'end_zone' => $end_zone 
					] );
				}
			}
		}
	}
}
