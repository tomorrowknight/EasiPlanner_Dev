<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;
use chief725\libs\Utils;
use yii\helpers\ArrayHelper;
use chief725\libs\__;

/* @var $this yii\web\View */
/* @var $model app\models\Parcel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parcel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'identifier')->textInput(['maxlength' => 255])?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 255])?>

	<?= $form->field($model, 'postal')->textInput(['maxlength' => 6])?>

    <?= $form->field($model, 'note')->textInput()?>

    <?= $form->field($model, 'deliver_time')->textInput()?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 255])?>

    <?= $form->field($model, 'customer_name')->textInput(['maxlength' => 122])?>

    <?= $form->field($model, 'volume')->textInput(['maxlength' => 122])?>
    <?= $form->field($model, 'weight')->textInput(['maxlength' => 122])?>
    <?= $form->field($model, 'service_time')->textInput(['maxlength' => 122])?>
    <?= $form->field($model, 'window_start')->textInput(['maxlength' => 122])?>
    <?= $form->field($model, 'window_end')->textInput(['maxlength' => 122])?>
	<?= $form->field($model, 'lat')->textInput() ?>
	<?= $form->field($model, 'lng')->textInput() ?>
	<?
	$typesArr = __::from(Yii::$app->user->identity->vehicleTypes)->groupBy(function ($type){return $type->category;});
	foreach ($typesArr as $category =>$types){
		echo Html::tag("label",ucfirst($category));
		echo $form->field ( $model, "vehicle_types[$category]",['labelOptions'=>['style'=>"display:none"]] )->checkboxList ( ArrayHelper::map ( $types, 'id', 'name' ), array_merge ( [ 'class' => "",'separator' => " | " ] ) );
	}
	?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?
$this->registerJsFile ( "//cdn.example8.com/datetimepicker/js/bootstrap-datetimepicker.min.js", [
		'depends' => [
				AppAsset::className ()
		]
] );
$this->registerJsFile ( "//cdn.example8.com/datetimepicker/js/moment.min.js" );
$this->registerCssFile ( "//cdn.example8.com/datetimepicker/css/bootstrap-datetimepicker.css" );

$today = date ( "Y-m-d" );
$js = <<<EOT
$("#parcel-window_start").datetimepicker({format: 'YYYY-MM-DD HH:mm:SS',defaultDate:'$today'});
$("#parcel-window_end").datetimepicker({format: 'YYYY-MM-DD HH:mm:SS',defaultDate:'$today'});
EOT;

$this->registerJs ( $js );

?>


<div id="map_canvas"
	style="height: 600px ; width: 100%"></div>
<script src="https://maps.google.com/maps/api/js?sensor=false&amp;libraries=drawing,geometry"></script>
<script>
//functions
var marker;
function initialize() {
	var myOptions = {
		zoom : parseInt(12),
		center : new google.maps.LatLng(1.34, 103.82),
		zoomControl : false
	};
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	google.maps.event.addListener(map, 'click', function(event) {
		marker.setPosition(event.latLng);
		$("#parcel-lat").val(event.latLng.lat());
		$("#parcel-lng").val(event.latLng.lng());
	});
	var markerPosition = new google.maps.LatLng(<?=Utils::select($model->lat,1.34) ?>, <?=Utils::select($model->lng,103.82)?>);
	marker = new google.maps.Marker({
		position : markerPosition,
		map : map,
		model : this
	});
}
initialize();
</script>