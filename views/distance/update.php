<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Distance $model */

$this->title = 'Update Distance: ' . $model->idDistance;
$this->params['breadcrumbs'][] = ['label' => 'Distances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idDistance, 'url' => ['view', 'idDistance' => $model->idDistance]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="distance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
