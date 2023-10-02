<?php

use app\models\Coordinate;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\CoordinateSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Coordenadas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coordinate-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idCoordinate',
            'latitude',
            'longitude',
            'time',
            //'token',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Coordinate $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'idCoordinate' => $model->idCoordinate]);
                 }
            ],
        ],
    ]); ?>


</div>
