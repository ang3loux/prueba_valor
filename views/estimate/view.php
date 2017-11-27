<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Estimate */

$this->title = $model->code;
$this->params['breadcrumbs'][] = ['label' => 'Cotizaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estimate-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'code',
            'seller_name',
            'client_name',
            'ruc',
            'total',
            'tax',
        ],
    ]) ?>

    <h3>Productos</h3>

    <div class="grid-view">
        <div class="summary"><b><?= count($model->productEstimates) ?></b> producto(s) contenido(s).</div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Precio $</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $index = 0;
                    foreach ($model->productEstimates as $value) {
                ?>
                    <tr>
                        <td>
                            <?= $index + 1 ?>
                        </td>
                        <td>
                            <?= $value->product->description ?>
                        </td>
                        <td>
                            <?= $value->product->type ?>
                        </td>
                        <td>
                            <?= $value->price ?>
                        </td>
                        <td>
                            <?= $value->quantity ?>
                        </td>
                    </tr>
                <?php
                        $index++;
                    }
                ?>
            </tbody>        
        </table>
    </div>

    <h3>Paquetes</h3>

    <div class="grid-view">
        <div class="summary"><b><?= count($model->promotionEstimates) ?></b> producto(s) contenido(s).</div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descripción</th>
                    <th>Descuento</th>
                    <th>Total $</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $index = 0;
                    foreach ($model->promotionEstimates as $value) {
                ?>
                    <tr>
                        <td>
                            <?= $index + 1 ?>
                        </td>
                        <td>
                            <?= $value->promotion->description ?>
                        </td>
                        <td>
                            <?= $value->promotion->deduction ?>
                        </td>
                        <td>
                            <?= $value->price ?>
                        </td>
                    </tr>
                <?php
                        $index++;
                    }
                ?>
            </tbody>        
        </table>
    </div>

</div>
