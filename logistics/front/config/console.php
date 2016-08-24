<?php
Yii::setAlias ( '@tests', dirname ( __DIR__ ) . '/tests' );
Yii::setAlias ( '@webroot', dirname ( __DIR__ ) . '/web' );
$params = require (__DIR__ . '/params.php');
$db = require (__DIR__ . '/db.php');

return [
		'id' => 'Easy Planner',
		'basePath' => dirname ( __DIR__ ),
		'bootstrap' => [
				'log',
				'gii'
		],
		'controllerNamespace' => 'app\commands',
		'modules' => [
				'gii' => 'yii\gii\Module' ,
				'user' => [
						'class' => 'amnah\yii2\user\Module',
						'modelClasses'  => [
								'Profile' => 'app\models\MyProfile',
						],
				],
		],
		'components' => [
				'cache' => [
						'class' => 'yii\caching\FileCache'
				],
				'log' => [
						'targets' => [
								[
										'class' => 'yii\log\FileTarget',
										'levels' => [
												'error',
												'warning'
										]
								]
						]
				],
				'user' => [
						'class' => 'amnah\yii2\user\components\User',
						'identityClass' => 'app\models\MyUser',
						'enableAutoLogin' => true
				],
				'db' => $db
		],
		'params' => $params
];
