<?php

namespace chief725\models;

use Yii;

/**
 * This is the model class for table "url".
 *
 * @property integer $id
 * @property string $url
 */
class Link extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['url'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
        ];
    }
    
    public static function exists($url){
    	return self::findOne(['url'=>$url]);
    }
    
    public static function createLink($url){
    	$link = new static();
    	$link->url = $url;
    	$link->save();
    }
    
    public static function touch($url){
    	if (self::exists($url)){
    		return false;
    	}
    	self::createLink($url);
    	return true;
    }
}
