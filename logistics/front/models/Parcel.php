<?php

namespace app\models;

use chief725\libs\GoogleMap;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "parcel".
 *
 * @property integer $id
 * @property string $identifier
 * @property string $address
 * @property string $postal
 * @property double $lat
 * @property double $lng
 * @property string $note
 * @property string $deliver_time
 * @property string $phone
 * @property string $customer_name
 */
class Parcel extends BelongToUser {
	const STATUS_REJECTED = 2;
	const STATUS_FAIL = 3;
	const STATUS_PENGING = 0;
	const STATUS_DONE = 1;
	public $csv_file;

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'parcel';
	}
	public static function getStatusLabels() {
		return [
				self::STATUS_REJECTED => [
						'text' => "REJECTED",
						'color' => "danger"
				],
				self::STATUS_FAIL => [
						'text' => "FAIL",
						'color' => "warning"
				],
				self::STATUS_PENGING => [
						'text' => "PENDING",
						'color' => "info"
				],
				self::STATUS_DONE => [
						'text' => "DONE",
						'color' => "success"
				]
		];
	}
	public function getStatusLabel() {
		$arr = self::getStatusLabels ();
		return Html::tag ( "label", $arr [$this->status] ['text'], [
				'class' => "label label-" . $arr [$this->status] ['color']
		] );
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
				[
						[
								'postal'
						],
						'required'
				],
				[
						[
								'lat',
								'lng',
								'volume',
								'weight',
								'vehicle_id',
								'driver_id',
								'service_time'
						],
						'number'
				],
				// ['identifier', 'unique', 'targetAttribute' => ['user_id', 'identifier']],
				[
						[
								'deliver_time',
								'note',
								'service_time',
								'window_start',
								'window_end',
								'vehicle_types',
								'signature',
						],
						'safe'
				],
				[
						[
								'identifier',
								'address',
								'phone',
								'postal'
						],
						'string',
						'max' => 255
				],
				[
						[
								'customer_name'
						],
						'string',
						'max' => 122
				],
				[
						[
								'failed',
								'seq',
								'route'
						],
						'integer'
				],
				[
						[
								'planned_deliver_time'
						],
						'number'
				]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
				'id' => 'ID',
				'identifier' => 'Identifier',
				'vehicle_id' => "Vehicle",
				'driver_id' => "Driver",
				'address' => 'Address',
				'lat' => 'Lat',
				'lng' => 'Lng',
				'note' => 'Note',
				'postal' => 'Postal',
				'deliver_time' => 'Actual Deliver Time',
				'service_time' => "Service Time",
				'phone' => 'Phone',
				'customer_name' => 'Customer Name',
				'window_start' => "Time window start",
				'window_end' => "Time window end",
				'signature' => "Signature",
		];
	}
	public function getVehicle() {
		return $this->hasOne ( Vehicle::className (), [
				'id' => 'vehicle_id'
		] );
	}

	public function getImages(){
		return $this->hasMany(Image::className(), ['parcel_id'=>"id"]);
	}
	public function beforeSave($insert) {
		if (parent::beforeSave ( $insert )) {
			$this->postal = substr ( "000000$this->postal", - 6 );
			self::updateLatLng ();
			return true;
		} else {
			return false;
		}
	}
	public function beforeValidate() {
		if (is_array ( $this->vehicle_types ))
			$this->vehicle_types = serialize ( $this->vehicle_types );
		return parent::beforeValidate ();
	}
	public function afterFind() {
		parent::afterFind ();
		if (! is_array ( $this->vehicle_types )) {
			$this->vehicle_types = unserialize ( $this->vehicle_types );
		}
	}
	public function updateLatLng($forceUpdate = false) {
		if (empty ( $this->lat ) && ! empty ( $this->postal )) {
			$geocode = Geocode::findGeocode ( $this->postal );
			if (empty ( $geocode ) && $forceUpdate) {
				$latlng = (new GoogleMap ())->getLatLng ( "sg $this->postal", 'sg' );
				Yii::$app->cache->set ( $this->postal, $latlng, 3600 * 24 * 180 );
				Geocode::updateGeocode ( $this->postal, $latlng ['lat'], $latlng ['lng'] );
				$geocode = Geocode::findGeocode ( $this->postal );
			}
			if (! empty ( $geocode )) {
				$this->lat = $geocode->lat;
				$this->lng = $geocode->lng;
			}
		}
	}
}
