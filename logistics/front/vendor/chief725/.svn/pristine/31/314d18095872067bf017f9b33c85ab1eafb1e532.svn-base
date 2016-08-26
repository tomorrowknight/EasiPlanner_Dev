<?php

namespace chief725\models;

use Yii;

/**
 * This is the model class for table "follow".
 *
 * @property integer $id
 * @property integer $followee_id
 * @property integer $follower_id
 * @property string $created
 */
class Follow extends BaseRecord
{
	public static $follower_id = "follower_id";
	public static $followee_id = "followee_id";
	
	public static function tableName()
	{
		return 'follow';
	}
	
    public static function create($follower_id,$followee_id){
    	if (!self::exists($follower_id, $followee_id)){
    		$fav = new static();
    		$fav->{static::$follower_id} = $follower_id;
    		$fav->{static::$followee_id} = $followee_id;
    		if (!$fav->save()){
    			throw new Exception("500");
    		}
    	}
    }
    
    public static function exists($follower_id,$followee_id){
    	return null != self::findOne([static::$follower_id=>$follower_id,static::$followee_id=>$followee_id]);
    }
    
    public static function remove($follower_id,$followee_id){
    	self::deleteAll([static::$follower_id=>$follower_id,static::$followee_id=>$followee_id]);
    }
    
    public static function countByFollowee($followee_id){
    	return self::find()->where([static::$followee_id=>$followee_id])->count();
    }
    
    public static function countByFollower($follower_id){
    	return self::find()->where([static::$follower_id=>$follower_id])->count();
    }
}
