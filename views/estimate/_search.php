<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EstimateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estimate-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'seller_name') ?>

    <?= $form->field($model, 'client_name') ?>

    <?= $form->field($model, 'ruc') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'tax') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
