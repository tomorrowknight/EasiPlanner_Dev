<?php
// functions

function t($msg,$params = null){
	return Yii::t("strings",$msg,$params);
}

function __autoload($className) {
	if (file_exists($className . '.php')) {
		require_once $className . '.php';
		return true;
	}
	return false;
}

// configs
header('Content-Type: text/html; charset=utf-8');

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);

$yii=dirname(__FILE__).'/../yii/yiilite.php';
$config=dirname(__FILE__).'/protected/config/main.php';

