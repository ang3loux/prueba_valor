<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Estimate */

$this->title = 'Create Estimate';
$this->params['breadcrumbs'][] = ['label' => 'Estimates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estimate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
