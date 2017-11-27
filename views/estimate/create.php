<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Estimate */

$this->title = 'Crear Cotización';
$this->params['breadcrumbs'][] = ['label' => 'Cotizaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estimate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsProductEstimate' => $modelsProductEstimate,
        'modelsPromotionEstimate' => $modelsPromotionEstimate
    ]) ?>

</div>
