<?php

namespace app\models;

use Yii;
use chief725\libs\__;

/**
 * This is the model class for table "vehicle_type".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $category
 * @property string $name
 * @property integer $seq
 */
class VehicleType extends BelongToUser {
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'vehicle_type';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
				[
						[
								'user_id',
								'category',
								'name',
								'seq'
						],
						'required'
				],
				[
						[
								'user_id',
								'seq'
						],
						'integer'
				],
				[
						[
								'category',
								'name'
						],
						'string',
						'max' => 100
				]
		];
	}
	public function __toString() {
		return "$this->category.$this->name";
	}
	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
				'id' => 'ID',
				'user_id' => 'User ID',
				'category' => 'Category',
				'name' => 'Name',
				'seq' => 'Seq'
		];
	}
	public static function getTexts($ids) {
		if (! is_array ( $ids ))
			return "";
		$ids = self::flatten ( $ids );
		$lookups = self::find ()->where ( [
				"in",
				"id",
				$ids
		] )->all ();
		$texts = __::from ( $lookups )->map ( function ($lookup) {
			return "$lookup";
		} );
		return join ( ", ", $texts );
	}
	static function flatten(array $array) {
		$return = array ();
		array_walk_recursive ( $array, function ($a) use(&$return) {
			$return [] = $a;
		} );
		return $return;
	}
}
