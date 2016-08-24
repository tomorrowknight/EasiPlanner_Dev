<?
use yii\grid\GridView;
use yii\helpers\Html;
use chief725\libs\Utils;
use app\libs\U;
$this->title = "$model->name parcels";

$this->params ['breadcrumbs'] [] = [ 
		'label' => 'Vehicles',
		'url' => [ 
				'index' 
		] 
];
$this->params ['breadcrumbs'] [] = [ 
		'label' => $model->name,
		'url' => [ 
				'view',
				'id' => $model->id 
		] 
];
$this->params ['breadcrumbs'] [] = 'Parcels';

?>
<h3><?=$this->title ?></h3>

<?
$prevDate = date ( "Y-m-d", strtotime ( $date ) - 60 * 60 * 24 );
$nextDate = date ( "Y-m-d", strtotime ( $date ) + 60 * 60 * 24 );
?>

<div class="btn-group margin-bottom-10" role="group" aria-label="...">
	<?=Html::a(Utils::iconfa("arrow-left").U::date2Label($prevDate),['parcels',"id"=>$model->id,'date'=>$prevDate],['class'=>"btn btn-default"])?>
	<?=Html::a(U::date2Label($date),['parcels',"id"=>$model->id,'date'=>$date],['class'=>"btn btn-primary"])?>
	<?=Html::a(U::date2Label($nextDate)." ".Utils::iconfa("arrow-right"),['parcels',"id"=>$model->id,'date'=>$nextDate],['class'=>"btn btn-default"])?>
</div>


<?
echo GridView::widget ( [ 
		'dataProvider' => $dataProvider,
		'columns' => [ 
				[ 
						'class' => 'yii\grid\SerialColumn' 
				],
				
				'identifier',
				'address',
				'postal',
				'note',
				'phone',
				'customer_name',
				'volume',
				'weight',
				'service_time',
				'window_start',
				'window_end',
				'deliver_time',
				[ 
						
						'label' => "planned_deliver_time",
						'attribute' => "planned_deliver_time",
						'value' => function ($model) {
							// return $model->planned_deliver_time;
							return date ( "H:i", $model->planned_deliver_time * 60 );
						} 
				],
				'lat',
				'lng',
				[ 
						'label' => 'Status',
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
						'class' => 'yii\grid\ActionColumn' 
				] 
		] 
] );
?>