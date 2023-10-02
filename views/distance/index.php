<?php

use app\models\Distance;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\DistanceSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Distancias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distance-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idDistance',
            'meters',
            'kilometers',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Distance $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'idDistance' => $model->idDistance]);
                 }
            ],
        ],
    ]); ?>


</div>
