<?php

namespace chief725\models;

use yii\helpers\Markdown;

use yii\helpers\Html;

use Yii;

class Setting extends BaseRecord
{
	public static function tableName(){
		return 'setting';
	}
	
    public function rules(){
        return [
            [['title'], 'unique'],
            [['content'], 'string']
        ];
    }

    public function afterSave($insert, $changedAttributes){
    	Yii::$app->apccache->set($this->title,$this->content,3600*24*7);
    	return parent::afterSave($insert, $changedAttributes);
    }
    
    public static function get($title,$default=""){
    	$content = Yii::$app->apccache->get($title);
    	if ($content === false){
	    	$setting = self::findOne(['title'=>$title]);
    		$content =empty($setting)? $default:$setting->content;
	    	Yii::$app->apccache->set($title,$content,3600*24*7);
    	}
    	return $content;
    }
    
    public static function set($title,$content){
    	$setting = self::findOne(['title'=>$title]);
    	if (empty($setting)) {
    		$setting = new Setting();
    		$setting->title = $title;
    	}
    	$setting->content = (string)$content;
    	if(!$setting->save()){
    		print_r($setting->getErrors());
    		exit;
    	}
    	echo Yii::$app->apccache->get($title);
    }
    
    public static function exists($key){
    	$val = self::get($key);
    	return !empty($val);
    }
    
    public static function displayText($key,$alertType=null){
    	if (self::exists($key)) {
    		if ($alertType==null){
    			echo Markdown::process(self::get($key));
    		}else{
    			echo Html::tag("div", Markdown::process(self::get($key)),['class'=>"alert alert-$alertType"]);
    		}
    	}
    }
}

