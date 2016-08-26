<?php

namespace chief725\models;

use yii\helpers\Url;

use Yii;

class Node extends BaseRecord
{
	public static function tableName()
	{
		return 'node';
	}
    public function getCover(){
    	return $this::hasOne(Image::className(), ['node_id'=>"id"]);
    }
    
    public function getImages(){
    	return $this::hasMany(Image::className(), ['node_id'=>"id"]);
    }
    
    public function getCategory(){
    	return $this::hasOne(Category::className(), ['id'=>"category_id"]);
    }
    
    public function getFavorites(){
    	return $this::hasMany(Favorite::className(), ['node_id'=>"id"]);
    }
    
    public function getUser(){
    	return $this::hasOne(User::className(), ["id"=>"user_id"]);
    }
}
