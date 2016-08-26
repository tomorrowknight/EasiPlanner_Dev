<?php

namespace chief725\page\models;


use chief725\libs\Trans;

use yii\db\ActiveRecord;

use Yii;
use chief725\libs\Trans3;

class Page extends ActiveRecord
{
	public static function tableName(){
		return 'page';
	}
	
    public function rules(){
        return [
            [['title'], 'unique'],
            [['content'], 'string']
        ];
    }

    public static function get($title,$default=""){
    	$title = trim(Trans3::getInstance()->toJian($title));
    	$content = Yii::$app->cache->get($title);
    	if (empty($content)){
	    	$setting = self::findOne(['title'=>$title]);
    		$content =empty($setting)? $default:$setting->content;
	    	Yii::$app->cache->set($title,$content,3600*24*7);
    	}
    	return $content;
    }
    
    public static function set($title,$content){
    	$title = trim(Trans3::getInstance()->toJian($title));
    	$setting = self::findOne(['title'=>$title]);
    	if (empty($setting)) {
    		$setting = new self();
    		$setting->title = $title;
    	}
    	$setting->content = $content;
    	$setting->save();
    	Yii::$app->cache->set($title,$content,3600*24*7);
    }
}

