<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Distance $model */

$this->title = $model->idDistance;
$this->params['breadcrumbs'][] = ['label' => 'Distances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="distance-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'idDistance' => $model->idDistance], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'idDistance' => $model->idDistance], [
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
            'idDistance',
            'meters',
            'kilometers',
        ],
    ]) ?>

</div>
