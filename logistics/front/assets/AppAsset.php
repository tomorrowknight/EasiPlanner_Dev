<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace app\assets;

use yii\web\View;
use yii\web\AssetBundle;

class AppAsset extends AssetBundle {
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
			'css/site.css',
			"//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"
	];
	public $js = [
			"js-main",
	];
	public $depends = [
			'yii\web\YiiAsset',
			'yii\bootstrap\BootstrapAsset',
			'yii\bootstrap\BootstrapPluginAsset'
	];
	public function init() {
		$this->jsOptions ['position'] = View::POS_END;
		parent::init ();
	}
}