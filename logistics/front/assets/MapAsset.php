<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace app\assets;

use yii\web\View;
use yii\web\AssetBundle;

class MapAsset extends AssetBundle {
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
			"css/site/index.css",
			"//cdn.example8.com/datetimepicker/css/bootstrap-datetimepicker.min.css",
			"https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css"
	];
	public $js = [
			"https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js",
			"https://maps.google.com/maps/api/js?sensor=false&libraries=drawing,geometry",
			"js/libs/spin.js",
			"js/libs/underscore-min.js",
			"js/libs/datetimepicker/js/moment.min.js",
			"js/libs/datetimepicker/js/bootstrap-datetimepicker.min.js",
			"js/libs/jquery.parseparams.js?v=1",
			"js/libs/backbone-min.js",
			"js/libs/supermodel.js",
			"js/libs/tinycolor.js",
			"js/map/algo.js",
			"js/map/tsptw.js",
			"js/map/near.js",
			"js/map/models.js",
			"js/map/index.js",
			"js/map/geo.js",
			'js/map/matrix.js'
	];
	public $depends = [
			'app\assets\AppAsset'
	];
	public function init() {
		$this->jsOptions ['position'] = View::POS_END;
		parent::init ();
	}
}
