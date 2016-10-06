<?php
use app\models\VehicleType;
use yii\grid\GridView;
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

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
							if(empty($model->signature))
								return "Empty";
								return Html::a ( "view", "data:image/jpeg;base64," . $model->signature );
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
								return Html::tag ( 'label', $model->failed ? "Fail" : "OK", [ 
										'class' => "label label-$labelClass" 
								] );
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
