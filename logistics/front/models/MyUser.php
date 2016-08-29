<?php

namespace app\models;

use app\models\Parcel;
use app\models\Vehicle;
use app\models\Driver;
use app\models\Horizon;
use amnah\yii2\user\models\User;
use amnah\yii2\user\models\Profile;

class MyUser extends User {
	/**
	 * get drivers
	 */
	public function getDrivers() {
		return $this->hasMany ( Driver::className (), [ 
				'user_id' => 'id' 
		] );
	}
	public function rules() {
		return array_merge ( parent::rules (), [ 
				[ 
						[ 
								'newPassword' 
						],
						'string',
						'min' => 6
				] 
		] );
	}
	
	/**
	 * get vehicles
	 */
	public function getVehicles() {
		return $this->hasMany ( Vehicle::className (), [ 
				'user_id' => 'id' 
		] );
	}
	public function getActiveVehicles() {
		return $this->hasMany ( Vehicle::className (), [ 
				'user_id' => 'id' 
		] )->andWhere ( [ 
				'flag' => 1 
		] );
	}
	
	/**
	 * get parcels
	 */
	public function getParcels() {
		return $this->hasMany ( Parcel::className (), [ 
				'user_id' => 'id' 
		] )->with ( "vehicle" );
	}
	public function getVehicleTypes() {
		return $this->hasMany ( VehicleType::className (), [ 
				'user_id' => 'id' 
		] );
	}
	
	/**
	 * get profile
	 */
	public function getProfile() {
		return $this->hasOne ( MyProfile::className (), [ 
				"user_id" => "id" 
		] );
	}
	
	/**
	 * Get the horizons
	 */
	public function getHorizons() {
		return $this->hasMany ( Horizon::className (), [ 
				'user_id' => 'id' 
		] )->orderBy ( "start asc" );
	}
	public function isAdmin() {
		return $this->can ( "admin" );
	}
	public function isEditor() {
		return $this->can ( "admin" );
	}
	public static function createUser($email, $username, $password, $role_id) {
		$user = new User ();
		$user->email = $email;
		$user->username = $username;
		$user->newPassword = $password;
		$user->role_id = $role_id;
		$user->status = User::STATUS_ACTIVE;
		if ($user->save ()) {
			$profile = new Profile ();
			$profile->full_name = $email;
			$profile->user_id = $user->id;
			$profile->save ();
		}
		return $user;
	}
	public static function createDriver($username, $password, $role_id) {
		$user = new User ();
		$email = "";
		$user->email = $email;
		$user->username = $username;
		$user->newPassword = $password;
		$user->role_id = $role_id;
		$user->status = User::STATUS_ACTIVE;
		if ($user->save ()) {
			$profile = new Profile ();
			$profile->full_name = $username;
			$profile->user_id = $user->id;
			$profile->save ();
		}
		return $user;
	}
}