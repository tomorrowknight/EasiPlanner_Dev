<?php
error_reporting(E_ALL);
ini_set('display_errors', True);

require_once 'DB.php';
require_once 'global.php';
require_once($yii);

Yii::setPathOfAlias('rootPath',dirname(__FILE__));
Yii::createWebApplication($config)->run();