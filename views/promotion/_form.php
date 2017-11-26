<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use app\models\Product;

/* @var $this yii\web\View */
/* @var $model app\models\Promotion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promotion-form">

    <?php $form = ActiveForm::begin(['id'=>'dynamic-form']); ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deduction')->textInput(['maxlength' => true]) ?>

    <div class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Añadir Productos</h4></div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 999, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsProductPromotion[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'quantity',
                    'product_id',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelsProductPromotion as $i => $modelProductPromotion): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Producto</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body"> 
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelProductPromotion, "[{$i}]product_id")->dropDownList(ArrayHelper::map(Product::find()->all(),'id','description'),
                                	['prompt'=>'Seleccionar Producto']) 
                                ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelProductPromotion, "[{$i}]quantity")->textInput(['maxlength' => true]) ?>
                            </div>
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
$form_script = <<< JS
	
		$(document).ready(function () {
			$(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
			    console.log("beforeInsert");
			});

			$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
			    console.log("afterInsert");
			});

			$(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
			    if (! confirm("Are you sure you want to delete this item?")) {
			        return false;
			    }
			    return true;
			});

			$(".dynamicform_wrapper").on("afterDelete", function(e) {
			    console.log("Deleted item!");
			});

			$(".dynamicform_wrapper").on("limitReached", function(e, item) {
			    alert("Limit reached");
			});
		})
JS;
$this->registerJs($form_script);
?>
