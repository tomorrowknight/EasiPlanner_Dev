<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\VehicleType;

/* @var $this yii\web\View */
/* @var $model app\models\Parcel */

$this->title = "Parcel #$model->id details";
$this->params['breadcrumbs'][] = ['label' => 'Parcels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="parcel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'identifier',
            'address',
    		'postal',
            'lat',
            'lng',
            'note',
            'deliver_time',
    		'service_time',
            'phone',
            'customer_name',
    		'volume',
        		[
        			'label' => 'Types',
        			'format' => 'raw',
        			'value' => VehicleType::getTexts ( $model->vehicle_types )
        		],
        ],
    ]) ?>

</div>
