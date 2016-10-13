<?php
use app\models\VehicleType;
use yii\grid\GridView;
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\Parcel;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parcels';
$this->params ['breadcrumbs'] [] = $this->title;

?>
<div class="parcel-index">

	<h1>
		<?= Html::encode($this->title)?>
	</h1>

	<p>
		<?= Html::a('Create Parcel', ['create'], ['class' => 'btn btn-success'])?>
		<?= Html::a('Import Parcels', ['import'], ['class' => 'btn btn-warning'])?>
		<?= Html::a('Export Parcels', array_merge(['export'],$_GET), ['class' => 'btn btn-info','target'=>"_blank"])?>
		<?= Html::a('Delete All Parcels', ['delete-all'], ['class' => 'btn btn-danger','onclick'=>"return confirm('Confirm delete?')"])?>
		<?= Html::a('Use Historical Service Time', [''], ['class' => 'btn btn-info','onclick'=>"return confirm('Use historical service time instead?')"])?>
		<button id='deleteSelectedBtn' class='btn btn-primary'
			onclick='deleteSelected()'>Delete Selected</button>
	</p>

	<?
	echo GridView::widget ( [ 
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'columns' => [ 
					[ 
							'class' => 'yii\grid\SerialColumn' 
					],
					[ 
							'class' => 'yii\grid\CheckboxColumn' 
					],
					// you may configure additional properties here
					
					'identifier',
					'address',
					'postal',
					'note',
					[ 
							'attribute' => 'vehicle',
							'label' => 'Vehicle',
							'value' => 'vehicle.name' 
					],
					// 'deliver_time',
					'phone',
					'customer_name',
					'volume',
					'weight',
					'service_time',
					'window_start',
					'window_end',
					'deliver_time',
					'lat',
					'lng',
					[ 
							'label' => 'Signature',
							'format' => 'raw',
							'attribute' => 'signature',
							'value' => function ($model) {
								if (is_null($model->signature))
									return "";
								return Html::a ( "view", "data:image/jpeg;base64," . $model->signature , ['target'=>'_blank'] );
							} 
					],
					[ 
							'label' => 'Image',
							'format' => 'raw',
							'attribute' => 'image',
							'value' => function ($model) {
								if (empty ( $model->image )) {
									return "";
								} else if (is_null($model->image) || strcmp('null',$model->image)!=0) {
									return "";
								} else {
									return Html::a ( "view", "data:image/jpeg;base64," . $model->image , ['target'=>'_blank']);
								}
							} 
					],
					
					[ 
							'label' => 'Geocode Status',
							'format' => 'raw',
							'attribute' => 'failed',
							'value' => function ($model) {
								if (empty ( $model->lat ))
									return "";
								$labelClass = $model->failed ? "danger" : "success";
								return Html::tag ( 'label', $model->failed ? "Fail" : "Success", [ 
										'class' => "label label-$labelClass" 
								] );
							} 
					],
					[ 
							'label' => 'Delivery Status',
							'format' => 'raw',
							'attribute' => 'status',
							'value' => function ($model) {
								$arr = Parcel::getStatusLabels ();
								if ($model->status == 1) {
									$done = Parcel::STATUS_DONE;
									return Html::tag ( "label", $arr [$done] ['text'], [ 
											'class' => "label label-" . $arr [$done] ['color'] 
									] );
								} else if ($model->status == 2) {
									$rejected = Parcel::STATUS_REJECTED;
									return Html::tag ( "label", $arr [$rejected] ['text'], [ 
											'class' => "label label-" . $arr [$rejected] ['color'] 
									] );
								} else if ($model->status == 3) {
									$failed = Parcel::STATUS_FAIL;
									return Html::tag ( "label", $arr [$failed] ['text'], [ 
											'class' => "label label-" . $arr [$failed] ['color'] 
									] );
								} else {
									$pending = Parcel::STATUS_PENDING;
									return Html::tag ( "label", $arr [$pending] ['text'], [ 
											'class' => "label label-" . $arr [$pending] ['color'] 
									] );
								}
							} 
					],
					[ 
							'label' => 'Types',
							'value' => function ($model) {
								return VehicleType::getTexts ( $model->vehicle_types );
							} 
					],
					
					[ 
							'class' => 'yii\grid\ActionColumn' 
					] 
			] 
	] );
	?>
</div>


<?
$this->registerJsFile ( "//cdn.example8.com/datetimepicker/js/bootstrap-datetimepicker.min.js", [ 
		'depends' => [ 
				AppAsset::className () 
		] 
] );
$this->registerJsFile ( "//cdn.example8.com/datetimepicker/js/moment.min.js" );
$this->registerCssFile ( "//cdn.example8.com/datetimepicker/css/bootstrap-datetimepicker.css" );

$todayBegin = date ( "Y-m-d 00:00:00" );
$todayEnd = date ( "Y-m-d 23:59:59" );

$js = <<<EOT
$('input[name="ParcelSearch[window_start]"]').datetimepicker({format: 'YYYY-MM-DD HH:mm:SS',defaultDate:'$todayBegin'});
$('input[name="ParcelSearch[window_end]"]').datetimepicker({format: 'YYYY-MM-DD HH:mm:SS',defaultDate:'$todayEnd'});
EOT;

$this->registerJs ( $js );

?>

<script>
function deleteSelected(){
    var deleteIds = $('#w0').yiiGridView('getSelectedRows');
    $.ajax({
        type: 'POST',
        url : '<?=Url::to(['multiple-delete'])?>',
        data : {deleteIds: deleteIds},
        success : function() {
        	$('#w0 input:checked').closest("tr").remove();
        }
    });
};
</script>
