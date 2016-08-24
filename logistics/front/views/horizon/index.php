<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Horizons';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horizon-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Horizon', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'start',
            'end',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
