<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '-ab05p9ooDOXSQG4VENCQvupiYwBMOII',
            'parsers' => [
            	'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
            'messageConfig' => [
           	 	'from' => ['admin@website.com' => 'Admin'], // this is needed for sending emails
            	'charset' => 'UTF-8',
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'user' => [
	        'class' => 'amnah\yii2\user\components\User',
	        'enableAutoLogin' => true,
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
	        'class' => 'yii\web\UrlManager',
	        'enablePrettyUrl' => true,
	        'showScriptName' => false,
	        'rules' => [
	       		 ['class' => 'yii\rest\UrlRule', 'controller' => 'location'],
	        ],
        ],
        'view' => [
	        'theme' => [
		        'pathMap' => [
		        	'@vendor/amnah/yii2-user/views' => '@app/views/user', // example: @app/views/user/default/login.php
		        ],
	        ],
        ],
    ],
    'modules' => [
	    'user' => [
		    'class' => 'amnah\yii2\user\Module',
	    ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
