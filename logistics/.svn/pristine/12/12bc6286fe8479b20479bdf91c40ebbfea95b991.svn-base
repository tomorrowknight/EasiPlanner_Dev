<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\View;

use yii\web\AssetBundle;

class SiteIndexAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';

	public $css = [
	"http://openlayers.org/en/master/css/ol.css",
	"css/site/index.css"
	];

	public $js = [
	"http://openlayers.org/en/master/build/ol.js",
	"js/site/index.js"
	];

	public $depends = [
	'app\assets\AppAsset',
	];
	
	public function init() {
		$this->jsOptions['position'] =View::POS_END;
		parent::init();
	}
}
