<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\View;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';

	public $css = [
	'css/site.css',
	];

	public $js = [
	"http://underscorejs.org/underscore-min.js"
	];


	public $depends = [
	'yii\web\YiiAsset',
	'yii\bootstrap\BootstrapAsset',
	'yii\bootstrap\BootstrapPluginAsset'
	];

	public function init() {
		$this->jsOptions['position'] =View::POS_HEAD;
		parent::init();
	}
}
