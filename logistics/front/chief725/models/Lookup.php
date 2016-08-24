<?php

namespace chief725\models;

use Yii;

/**
 * This is the model class for table "lookup".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $title
 */
class Lookup extends BaseRecord
{
	public function rules()
	{
		return [
				[['title'], 'string'],
				[['parent_id','hits'],'integer']
		];
	}
    public static function tableName()
    {
        return 'lookup';
    }

    public function getChildren(){
    	return self::hasMany(self::className(), ["parent_id"=>"id"])->orderBy("hits desc, id asc");
    }
    
    public function getParent(){
    	return self::hasOne(self::className(), ["id"=>"parent_id"]);
    }
    
    public static function getList($title){
    	$lookup = self::getByTitle($title);
    	return $lookup->children;
    }
    
    public static function getByTitle($title){
    	return self::findOne(array("title"=>$title));
    }
    
    public function beforeSave($insert){
    	$this->title = trim($this->title);
    	return parent::beforeSave($insert);
    }
}
