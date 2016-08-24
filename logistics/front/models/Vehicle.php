<?php

namespace app\models;

use Yii;
use chief725\libs\Utils;

/**
 * This is the model class for table "vehicle".
 *
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 * @property integer $driver_id
 * @property integer $capacity_volume
 */
class Vehicle extends BelongToUser {
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'vehicle';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
				[
						[
								'name',
								'capacity_volume',
								'capacity_weight'
						],
						'required'
				],
				[
						[
								'user_id',
								'driver_id',
								'flag'
						],
						'integer'
				],
				[
						[
								'capacity_volume',
								'capacity_weight'
						],
						'number'

				],
				[
						[
								'name'
						],
						'string',
						'max' => 100
				],
				[
						[
								'types'
						],
						'safe'
				]
				
		];
	}
	public function beforeSave($insert) {
		if (parent::beforeSave ( $insert )) {
			if (! empty ( $this->driver_id )) {
				$this->driver->free ();
			}
			return true;
		} else {
			return false;
		}
	}
	public function beforeValidate() {
		// Utils::print_d($this->types);exit;
		if (is_array ( $this->types ))
			$this->types = serialize ( $this->types );
		return parent::beforeValidate ();
	}
	public function afterFind() {
		parent::afterFind ();
		if (! is_array ( $this->types )) {
			$this->types = unserialize ( $this->types );
		}
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
				'id' => 'ID',
				'name' => 'Name',
				'user_id' => 'User ID',
				'driver_id' => 'Driver ID',
				'capacity_volume' => 'Capacity Volume',
				'capacity_weight' => 'Capacity Weight'
		];
	}
	public function getDriver() {
		return $this->hasOne ( Driver::className (), [
				'id' => 'driver_id'
		] );
	}
	public function getParcels() {
		return $this->hasMany ( Parcel::className (), [
				'vehicle_id' => 'id'
		] )->with ( "vehicle" )->orderBy("route asc, seq asc");
	}
}
