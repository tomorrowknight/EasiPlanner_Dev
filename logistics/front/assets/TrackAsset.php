<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace app\assets;

use yii\web\View;
use yii\web\AssetBundle;

class TrackAsset extends AssetBundle {
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [ ];
	public $js = [
			'js/libs/signature_pad.js',
			'js/track/view.js'
	];
	public $depends = [
			'app\assets\AppAsset'
	];
	public function init() {
		$this->jsOptions ['position'] = View::POS_END;
		parent::init ();
	}
}
