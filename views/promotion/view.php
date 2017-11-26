<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Promotion */

$this->title = $model->description;
$this->params['breadcrumbs'][] = ['label' => 'Paquetes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promotion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            // 'description',
            'deduction',
            'total'
        ],
    ]) ?>
    
    <div class="grid-view">
        <div class="summary"><b><?= count($model->productPromotions) ?></b> producto(s) contenido(s).</div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $index = 0;
                    foreach ($model->productPromotions as $value) {
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
                    </tr>
                <?php
                        $index++;
                    }
                ?>
            </tbody>        
        </table>
    </div>

</div>
