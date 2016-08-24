<?php
$params = require (__DIR__ . '/params.php');

$config = [
		'id' => 'Easy Planner',
		'basePath' => dirname ( __DIR__ ),
		'name'=>"Easy Planner",
		'bootstrap' => [
				'log',
				function () {
					return Yii::$app->getModule ( "user" );
				}
		],
		'components' => [
				'request' => [
						// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
						'cookieValidationKey' => '-ab05p9ooDOXSQG4VENCQvupiYwBMOII',
						'parsers' => [
								'application/json' => 'yii\web\JsonParser'
						]
				],
				'cache' => [
						'class' => 'yii\caching\FileCache'
				],
				'errorHandler' => [
						'errorAction' => 'site/error'
				],
				'mailer' => [
						'class' => 'yii\swiftmailer\Mailer',
						'useFileTransport' => false,
						'transport' => [
								'class' => 'Swift_SmtpTransport',
								'host' => 'in-v3.mailjet.com',
								'username' => 'ba13091f1bdbebf56cd0339eedf94b76',
								'password' => 'b648066c7ea3add2f9f39be012215f2b',
								'port' => '587'
						]
				],
				'log' => [
						'traceLevel' => YII_DEBUG ? 3 : 0,
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
				'db' => require (__DIR__ . '/db.php'),
				'urlManager' => [
						'class' => 'yii\web\UrlManager',
						'enablePrettyUrl' => true,
						'showScriptName' => false,
						'rules' => [
								[
										'class' => 'yii\rest\UrlRule',
										'controller' => 'parcels'
								],
								[
										'class' => 'yii\rest\UrlRule',
										'controller' => 'drivers'
								],
								"/js-<path>" => "site/js",
								"/" => "site/index"
						]
				],
				'view' => [
						'theme' => [
								'pathMap' => [
										'@vendor/amnah/yii2-user/views' => '@app/views/user'
								] // example: @app/views/user/default/login.php

						]
				]
		],
		'modules' => [
				'user' => [
						'class' => 'amnah\yii2\user\Module',
						'modelClasses' => [
								'Profile' => 'app\models\MyProfile',
								"Role"=>'app\models\Role'
						]
				],
				'lookup' => [
						'class' => 'chief725\lookup\Module'
				]
		],
		'params' => $params
];

if (YII_ENV_DEV) {
	// configuration adjustments for 'dev' environment
	$config ['bootstrap'] [] = 'debug';
	$config ['modules'] ['debug'] = 'yii\debug\Module';

	$config ['bootstrap'] [] = 'gii';
	$config ['modules'] ['gii'] = 'yii\gii\Module';
}

return $config;
