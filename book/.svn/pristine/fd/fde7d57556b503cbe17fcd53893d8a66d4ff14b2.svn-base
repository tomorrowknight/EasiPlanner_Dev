<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$webroot = Yii::getPathOfAlias('rootPath');
return array(
		'sourceLanguage' => 'en',
		'defaultController' => 'site',
		//'theme'=>$detect->isMobile()?"mobile":null,
		//'theme'=>"mobile",
		'name'=>"",

		// preloading 'log' component
		'preload'=>array('log'),

		// Gzip
		//'onBeginRequest'=>create_function('$event', 'return ob_start("ob_gzhandler");'),
		//'onEndRequest'=>create_function('$event', 'return ob_end_flush();'),
		// autoloading model and component classes
		'import'=>array(
				'application.models.*',
				'application.components.*',
				'application.extensions.*',
				'application.extensions.oauth.*',
				'application.extensions.oauth.facebook.*',
		),

		'modules'=>array(

				'gii'=>array(
						'class'=>'system.gii.GiiModule',
						'password'=>'123',
						// If removed, Gii defaults to localhost only. Edit carefully to taste.
						'ipFilters'=>array('127.0.0.1','::1'),
				),

		),

		// application components
		'components'=>array(
				'session' => array(
						'timeout' => 3600*24*3,
				),
				'user'=>array(
						// enable cookie-based authentication
						'allowAutoLogin'=>true,
				),
				// uncomment the following to enable URLs in path-format

				'urlManager'=>array(
						'urlFormat'=>'path',
						'showScriptName'=>false,
						'rules'=>array(
								'/<id:\d+>.html' =>"node/index",
								'/' => 'node/index',
								"/page/<title>"=>"page/view",
								"/admin"=>"node/admin",								
								'/sitemap.xml' => 'site/sitemap',
								'/manifest' => 'site/manifest',
						),
				),

				'email'=>array(
						'class'=>'application.extensions.email.Email',
						'delivery'=>'php', //Will use the php mailing function.
						//May also be set to 'debug' to instead dump the contents of the email into the view
				),

				'db'=>array(
						'connectionString' => 'mysql:host='.constant("DB_HOST").';dbname='.constant("DB_NAME"),
						'emulatePrepare' => true,
						'username' => constant("DB_USERNAME"),
						'password' => constant("DB_PASSWORD"),
						'charset' => 'utf8',
				),

				'errorHandler'=>array(
						// use 'site/error' action to display errors
						'errorAction'=>'site/error',
				),

				'log'=>array(
						'class'=>'CLogRouter',
						'routes'=>array(
								array(
										'class'=>'CFileLogRoute',
										'levels'=>'error,info',
								),
						),
				),
				'cache'=>array(
						'class'=>'system.caching.CDbCache',
						'connectionID'=>'db',
						'autoCreateCacheTable'=>true,
						'cacheTableName'=>'yiicache',
				),
				'settings'=>array(
						'class'             => 'CmsSettings',
						'cacheComponentId'  => 'cache',
						'cacheId'           => 'global_website_settings',
						'cacheTime'         => 84000,
						'tableName'     	=> 'settings',
						'dbComponentId'     => 'db',
						'createTable'       => true,
						'dbEngine'      	=> 'InnoDB',
				),
		),

		'params'=>array(
				// this is used in contact page
				'adminEmail'=>'shichengbbs@gmail.com',
		),
);