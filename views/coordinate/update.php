<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Coordinate $model */

$this->title = 'Update Coordinate: ' . $model->idCoordinate;
$this->params['breadcrumbs'][] = ['label' => 'Coordinates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idCoordinate, 'url' => ['view', 'idCoordinate' => $model->idCoordinate]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="coordinate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
