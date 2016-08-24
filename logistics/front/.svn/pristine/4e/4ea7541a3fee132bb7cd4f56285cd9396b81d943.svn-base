<?
use chief725\libs\Utils;
use chief725\libs\__;
use yii\helpers\Url;
use yii\helpers\Html;
use app\libs\U;
use app\models\Parcel;
?>
<?

if (empty ( $vehicle )) {
	echo '<div class="alert alert-warning">No vehicle is assigned to you.</div>';
	return;
}
?>

<h3><?=Utils::iconfa("car")."$vehicle->name ($driver->username)" ?> 
<button onclick='geoloc()' class='btn btn-success'><?=Utils::iconfa("map-marker")."Route $vehicle->name" ?></button></h3>

<script>
var watchId = null;
function geoloc() {
	if (navigator.geolocation) {
		var optn = {
			enableHighAccuracy : true,
			timeout : Infinity,
			maximumAge : 0
		};
		watchId = navigator.geolocation.watchPosition(showPosition, showError, optn);
	} else {
		alert('Geolocation is not supported in your browser');
	}
}
function showPosition(position) {
	x.innerHTML = "Latitude: " + position.coords.latitude + 
	"<br>Longitude: " + position.coords.longitude; 
}

function stopWatch() {
	if (watchId) {
		navigator.geolocation.clearWatch(watchId);
		watchId = null;

	}
}

function showError(error) {
	var err = document.getElementById('mapdiv');
	switch(error.code) {
	case error.PERMISSION_DENIED:
		err.innerHTML = "User denied the request for Geolocation."
		break;
	case error.POSITION_UNAVAILABLE:
		err.innerHTML = "Location information is unavailable."
		break;
	case error.TIMEOUT:
		err.innerHTML = "The request to get user location timed out."
		break;
	case error.UNKNOWN_ERROR:
		err.innerHTML = "An unknown error occurred."
		break;
	}
}
</script>


<?
$prevDate = date("Y-m-d",strtotime($date)-60*60*24);
$nextDate = date("Y-m-d",strtotime($date)+60*60*24);
?>

<div class="btn-group margin-bottom-10" role="group" aria-label="...">
<?=Html::a(Utils::iconfa("arrow-left").U::date2Label($prevDate),['index','date'=>$prevDate],['class'=>"btn btn-default"]) ?>
<?=Html::a(U::date2Label($date),['index','date'=>$date],['class'=>"btn btn-primary"]) ?>
<?=Html::a(U::date2Label($nextDate)." ".Utils::iconfa("arrow-right"),['index','date'=>$nextDate],['class'=>"btn btn-default"]) ?>

</div>

<?
$parcels = $vehicle->getParcels()->where(["DATE(window_start)"=>$date])->andWhere(["!=",'status',Parcel::STATUS_DONE])->all();
if (empty ( $parcels )) {
	echo "<div class='alert alert-warning'>No parcels are assigned to this vehicle on $date.</div>";
	return;
}
$parcelsRoutes = __::from ( $parcels)->groupBy ( function ($vehicle) {
	return $vehicle->route;
} );
?>


<?foreach ($parcelsRoutes as $parcels): ?>
<div class="list-group">
<?foreach ($parcels as $parcel): ?>
<a href="<?=Url::to(['track/view','id'=>$parcel->id]) ?>" target="_blank"
class="list-group-item">
<h4 class="list-group-item-heading"><?=$parcel->getStatusLabel()?></h4>
<h4 class="list-group-item-heading"><?="$parcel->customer_name" ?></h4>
<p class="list-group-item-text"><?=Utils::icon("map-marker")?> <?="$parcel->address(SG $parcel->postal)" ?></p>
<p class="list-group-item-text"><?=Utils::icon("calendar")?> <?=date("H:i:s",strtotime($parcel->window_start))." - ". 
date("H:i:s",strtotime($parcel->window_end)) ?></p>
<p class="list-group-item-text"><?=Utils::icon("time")?> <?=date("H:i:s",$parcel->planned_deliver_time*60) ?></p>
</a>
<?endforeach; ?>
</div>
<?endforeach; ?>