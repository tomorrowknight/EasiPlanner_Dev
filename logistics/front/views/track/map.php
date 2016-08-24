<?
use chief725\libs\Utils;
use app\assets\TrackAsset;
$this->params ['breadcrumbs'] [] = [
		'label' => "Parcel #$model->id",
		'url' => [
				'view',
				'id' => $model->id
		]
];
$this->params ['breadcrumbs'] [] = 'Map';


?>
<p><?=$model->address ?></p>
<div id="map_canvas" style="height: 600px; width: 100%"></div>
<script
	src="https://maps.google.com/maps/api/js?sensor=false&amp;libraries=drawing,geometry"></script>
<script>
//functions
var marker;
function initialize() {
	var myOptions = {
		zoom : 13,
		center : new google.maps.LatLng(<?=Utils::select($model->lat,1.34) ?>, <?=Utils::select($model->lng,103.82)?>),
		zoomControl : false
	};
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	marker = new google.maps.Marker({
		position : myOptions.center,
		map : map,
		model : this
	});
}
initialize();
</script>