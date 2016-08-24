<?php

namespace app\models;

use chief725\models\BaseRecord;
use Yii;
use chief725\libs\Log;
use chief725\libs\Utils;

/**
 * This is the model class for table "matrix_postal_static".
 *
 * @property integer $id
 * @property string $start
 * @property string $end
 * @property string $time
 * @property integer $duration
 * @property string $modified
 * @property string $start_zone
 * @property string $end_zone
 */
class MatrixPostal extends BaseRecord {
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'matrix_postal';
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [ 
				[ 
						[ 
								'modified' 
						],
						'safe' 
				],
				[ 
						[ 
								'start',
								'end' 
						],
						'string',
						'max' => 6 
				] 
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function beforeSave($insert) {
		if (! empty ( $this->start ))
			$this->start_zone = self::getZone ( $this->start );
		if (! empty ( $this->end ))
			$this->end_zone = self::getZone ( $this->end );
		return parent::beforeSave ( $insert );
	}
	public static function getZone($postal) {
		$zones = json_decode ( file_get_contents ( Yii::getAlias ( "@webroot/zone.json" ) ), true );
		return $zones [substr ( $postal, 0, 2 )];
		$prefix = substr ( $postal, 0, 2 );
	}

	public static function getSpeed($from, $to, $hour) {
		$zones = json_decode ( file_get_contents ( Yii::getAlias ( "@webroot/zone.json" ) ), true );
		$speeds = json_decode ( file_get_contents ( Yii::getAlias ( "@webroot/speeds.json" ) ), true );
		if (empty ( $zones [substr ( $from, 0, 2 )] ) || empty ( $zones [substr ( $to, 0, 2 )] )) {
			return 0;
		}
		$zone_from = $zones [substr ( $from, 0, 2 )];
		$zone_to = $zones [substr ( $to, 0, 2 )];
		if ($hour >= 7 && $hour <= 9) {
			$hour = 8;
		} elseif ($hour >= 17 && $hour <= 19) {
			$hour = 18;
		} else {
			$hour = 15;
		}
		return empty ( $speeds [$hour] [$zone_from] [$zone_to] ) ? 0 : $speeds [$hour] [$zone_from] [$zone_to];
	}
	public static function zoneMappingReverse() {
		$mapping = self::zoneMapping ();
		$mapping2 = [ ];
		foreach ( $mapping as $zone => $prefixs ) {
			foreach ( $prefixs as $prefix )
				$mapping2 [$prefix] = $zone;
		}
		return $mapping2;
	}
	public static function zoneMapping3() {
		$lines = file ( Yii::getAlias ( "@webroot/zone.csv" ) );
		$zoneArray = [ ];
		foreach ( $lines as $line ) {
			list ( $name, $prefix ) = explode ( ",", $line );
			if (empty ( $zoneArray [$name] ))
				$zoneArray [$name] = [ ];
				$zoneArray [$name] [] = str_pad ( trim ( $prefix ), 2, "0", STR_PAD_LEFT );
		}
		return $zoneArray;
	}
	public static function zoneMapping() {
		return [ 
				[ 
						"01",
						"02",
						"03",
						"04",
						"05" 
				],
				[ 
						"07",
						"08" 
				],
				[ 
						"14",
						"15",
						"16" 
				],
				[ 
						"09",
						"10" 
				],
				[ 
						"11",
						"12",
						"13" 
				],
				[ 
						"17" 
				],
				[ 
						"18",
						"19" 
				],
				[ 
						"20",
						"21" 
				],
				[ 
						"22",
						"23" 
				],
				[ 
						"24",
						"25",
						"26",
						"27" 
				],
				[ 
						"28",
						"29",
						"30" 
				],
				[ 
						"31",
						"32",
						"33" 
				],
				[ 
						"34",
						"35",
						"36",
						"37" 
				],
				[ 
						"38",
						"39",
						"40",
						"41" 
				],
				[ 
						"42",
						"43",
						"44",
						"45" 
				],
				[ 
						"46",
						"47",
						"48" 
				],
				[ 
						"49",
						"50",
						"81" 
				],
				[ 
						"51",
						"52" 
				],
				[ 
						"53",
						"54",
						"55",
						"82" 
				],
				[ 
						"56",
						"57" 
				],
				[ 
						"58",
						"59" 
				],
				[ 
						"60",
						"61",
						"62",
						"63",
						"64" 
				],
				[ 
						"65",
						"66",
						"67",
						"68" 
				],
				[ 
						"69",
						"70",
						"71" 
				],
				[ 
						"72",
						"73" 
				],
				[ 
						"77",
						"78" 
				],
				[ 
						"75",
						"76" 
				],
				[ 
						"79",
						"80" 
				] 
		];
	}
}
