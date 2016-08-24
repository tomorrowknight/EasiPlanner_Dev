<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\VehicleType;

/* @var $this yii\web\View */
/* @var $model app\models\Vehicle */

$this->title = $model->name;
$this->params ['breadcrumbs'] [] = [
		'label' => 'Vehicles',
		'url' => [
				'index'
		]
];
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="vehicle-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])?>
        <?=Html::a ( 'Delete', [ 'delete','id' => $model->id ], [ 'class' => 'btn btn-danger','data' => [ 'confirm' => 'Are you sure you want to delete this item?','method' => 'post' ] ] )?>
    </p>

    <?
				echo DetailView::widget ( [
						'model' => $model,
						'attributes' => [
								'id',
								'name',
								[
										'label' => 'Driver',
										'value' => empty ( $model->driver ) ? "" : $model->driver->username
								],
								'capacity_volume',
								'capacity_weight',
								[
										'label' => "Flag",
										'format' => 'raw',
										'value' => $model->flag ? "<span class='label label-success'>Active</span>" : "<span class='label label-danger'>Inactive</span>"
								],
								[
										'label' => 'Parcles',
										'format' => 'raw',
										'value' => Html::a ( $model->getParcels ()->count () . " Parcels", [
												'vehicle/parcels',
												"id" => $model->id
										] )
								],
								[
								'label' => 'Types',
								'format' => 'raw',
								'value' => VehicleType::getTexts ( $model->types )
								],

						]
				] )?>

</div>
