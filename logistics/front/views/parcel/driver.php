<?
use chief725\libs\Utils;
use chief725\libs\__;
use yii\helpers\Url;
use yii\helpers\Html;
use app\libs\U;
?>
<?

if (empty ( $vehicle )) {
	echo '<div class="alert alert-warning">No vehicle is assigned to you.</div>';
	return;
}
?>
<h3><?=Utils::iconfa("car")."$vehicle->name ($driver->username)" ?></h3>



<?
$prevDate = date("Y-m-d",strtotime($date)-60*60*24);
$nextDate = date("Y-m-d",strtotime($date)+60*60*24);
?>

<div class="btn-group margin-bottom-10" role="group" aria-label="...">
	<?=Html::a(Utils::iconfa("arrow-left").U::date2Label($prevDate),['driver','date'=>$prevDate],['class'=>"btn btn-default"]) ?>
	<?=Html::a(U::date2Label($date),['driver','date'=>$date],['class'=>"btn btn-primary"]) ?>
	<?=Html::a(U::date2Label($nextDate)." ".Utils::iconfa("arrow-right"),['driver','date'=>$nextDate],['class'=>"btn btn-default"]) ?>
</div>

<?
$parcels = $vehicle->getParcels()->where(["DATE(window_start)"=>$date])->all();
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
	  <a href="<?=Url::to(['parcel/deliver','id'=>$parcel->id]) ?>" target="_blank"
		class="list-group-item">
		<h4 class="list-group-item-heading"><?=$parcel->getStatusLabel()?> <?="$parcel->customer_name $parcel->phone" ?></h4>
		<h4 class="list-group-item-heading"><?="$parcel->address(SG $parcel->postal)" ?></h4>
		<p class="list-group-item-text"><?="$parcel->window_start - $parcel->window_end" ?></p>
		<p class="list-group-item-text">PDT: <?=date("H:i:s",$parcel->planned_deliver_time*60) ?></p>
	</a>
  	<?endforeach; ?>
</div>
<?endforeach; ?>