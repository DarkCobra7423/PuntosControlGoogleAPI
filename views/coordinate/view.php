<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Coordinate $model */

$this->title = $model->idCoordinate;
$this->params['breadcrumbs'][] = ['label' => 'Coordinates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="coordinate-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'idCoordinate' => $model->idCoordinate], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'idCoordinate' => $model->idCoordinate], [
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
            'idCoordinate',
            'latitude',
            'longitude',
            'time',
        ],
    ]) ?>

</div>
