<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Distance $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="distance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'meters')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kilometers')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
