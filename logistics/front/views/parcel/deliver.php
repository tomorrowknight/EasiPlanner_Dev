<?php
use yii\widgets\DetailView;
use app\models\VehicleType;
use chief725\libs\Utils;

?>
<?

echo DetailView::widget ( [
		'model' => $model,
		'attributes' => [
				'id',
				'identifier',
				'address',
				'postal',
				'note',
				'deliver_time',
				'service_time',
				'phone',
				'customer_name',
				'volume'
		]
] )?>


<div id="map_canvas" style="height: 600px; width: 100%"></div>
<script
	src="https://maps.google.com/maps/api/js?sensor=false&amp;libraries=drawing,geometry"></script>
<script>
//functions
var marker;
function initialize() {
	var myOptions = {
		zoom : parseInt(12),
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