<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Coordinate $model */

$this->title = 'Create Coordinate';
$this->params['breadcrumbs'][] = ['label' => 'Coordinates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coordinate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
