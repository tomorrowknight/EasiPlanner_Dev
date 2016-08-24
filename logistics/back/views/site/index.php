<?php
use app\assets\SiteIndexAsset;

use yii\helpers\Url;

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
$this->title = 'Logistics route planning';

SiteIndexAsset::register($this);
?>


<div id="map" class="map">
	<div id="popup"></div>
</div>
<div id="toolbox">
	<ul id="layerswitcher">
		<li><label><input type="radio" name="layer" value="0" checked> OSM</label>
		</li>
		<li><label><input type="radio" name="layer" value="1"> Bing Map</label>
		</li>
	</ul>
</div>

