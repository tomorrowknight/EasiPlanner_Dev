<?php

namespace chief725\lookup;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();
        $this->layoutPath = "@app/views/layouts";
    }
    
    public static function getSize($models, $attr){
    	$size =3;
    	foreach ($models as $model){
    		$size = max($size,strlen($model->$attr));
    	}
    	return min(100,$size+4);
    }
}
