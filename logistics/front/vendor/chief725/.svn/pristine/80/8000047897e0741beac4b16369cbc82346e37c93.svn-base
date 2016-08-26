<?php

namespace chief725\models;

use yii\helpers\Html;

use yii\helpers\Url;

use Yii;

/**
 * This is the model class for table "dish".
 *
 * @property integer $id
 * @property string $title
 * @property integer $parent_id
 * @property integer $hits
 */
class Category extends BaseRecord
{
	public static function tableName()
	{
		return 'category';
	}
    public function getParent(){
    	return $this->hasOne(self::className(), ["id"=>"parent_id"]);
    }
    
    public function getChildren(){
    	return $this->hasMany(self::className(), ["parent_id"=>"id"])->orderBy(self::getOrderBy());
    }
    
    public static function findParents(){
    	return self::find()->where("parent_id is null or parent_id = 0")->orderBy(self::getOrderBy());
    }
    
    private static function getOrderBy(){
    	$model = new static;
    	if($model->hasAttribute("hits")){
    		return "hits desc";
    	}
    	if($model->hasAttribute("seq")){
    		return "seq asc";
    	}
    	return "id asc";
    }
    
    public static function findByTitle($title){
    	return self::findOne(['title'=>$title]);
    }
    
    public static function findChidlrenByTitle($title){
    	$category = self::findByTitle($title);
    	return empty($category)?[]:$this->getChildren();
    }
    
    public function hit($col='hits'){
    	if (!empty($this->parent)){
    		$this->parent->hit($col);
    	}
    	parent::hit($col);
    }
}
