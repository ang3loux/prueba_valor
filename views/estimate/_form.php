<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use app\models\Product;
use app\models\Promotion;

/* @var $this yii\web\View */
/* @var $model app\models\Estimate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estimate-form">

    <?php $form = ActiveForm::begin(['id'=>'dynamic-form-estimate']); ?>

    <?= $form->field($model, 'seller_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'client_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ruc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tax')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-sm-6">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper_Product', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items-Product', // required: css class selector
                'widgetItem' => '.item-Product', // required: css class
                'limit' => 999, // the maximum times, an element can be added (default 999)
                'min' => 0, // 0 or 1 (default 1)
                'insertButton' => '.add-item-Product', // css class
                'deleteButton' => '.remove-item-Product', // css class
                'model' => $modelsProductEstimate[0],
                'formId' => 'dynamic-form-estimate',
                'formFields' => [
                    'product_id',
                    'quantity'
                ],
            ]); ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>
                        <i class="glyphicon glyphicon-envelope"></i> Productos
                        <button type="button" class="add-item-Product btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Añadir</button>
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="container-items-Product"><!-- widgetBody -->
                    <?php foreach ($modelsProductEstimate as $i => $objProductEstimate): ?>
                        <div class="item-Product panel panel-default"><!-- widgetItem -->
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left">Producto</h3>
                                <div class="pull-right">
                                    <button type="button" class="remove-item-Product btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <?= $form->field($objProductEstimate, "[{$i}]product_id")->dropDownList(ArrayHelper::map(Product::find()->all(),'id','description'),
                                            ['prompt'=>'Seleccionar Producto']) 
                                        ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?= $form->field($objProductEstimate, "[{$i}]quantity")->textInput(['maxlength' => true]) ?>
                                    </div>
                                </div><!-- .row -->
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div><!-- .panel -->
            <?php DynamicFormWidget::end(); ?>
        </div>

        <div class="col-sm-6">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper_Promotion', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items-Promotion', // required: css class selector
                'widgetItem' => '.item-Promotion', // required: css class
                'limit' => 999, // the maximum times, an element can be added (default 999)
                'min' => 0, // 0 or 1 (default 1)
                'insertButton' => '.add-item-Promotion', // css class
                'deleteButton' => '.remove-item-Promotion', // css class
                'model' => $modelsPromotionEstimate[0],
                'formId' => 'dynamic-form-estimate',
                'formFields' => [
                    'promotion_id'
                ],
            ]); ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>
                        <i class="glyphicon glyphicon-envelope"></i> Paquetes
                        <button type="button" class="add-item-Promotion btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Añadir</button>
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="container-items-Promotion"><!-- widgetBody -->
                    <?php foreach ($modelsPromotionEstimate as $i => $objPromotionEstimate): ?>
                        <div class="item-Promotion panel panel-default"><!-- widgetItem -->
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left">Promoción</h3>
                                <div class="pull-right">
                                    <button type="button" class="remove-item-Promotion btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                    <?= $form->field($objPromotionEstimate, "[{$i}]promotion_id")->dropDownList(ArrayHelper::map(Promotion::find()->all(),'id','description'),
                                        ['prompt'=>'Seleccionar Promoción']) 
                                    ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div><!-- .panel -->
            <?php DynamicFormWidget::end(); ?>
        </div> 
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
$form_script = <<< JS

        $(document).ready(function () {
            $(".dynamicform_wrapper_Product").on("beforeInsert", function(e, item) {
                console.log("beforeInsert");
            });

            $(".dynamicform_wrapper_Product").on("afterInsert", function(e, item) {
                console.log("afterInsert");
            });

            $(".dynamicform_wrapper_Product").on("beforeDelete", function(e, item) {
                if (! confirm("¿Está seguro que desea eliminar este item?")) {
                    return false;
                }
                return true;
            });

            $(".dynamicform_wrapper_Product").on("afterDelete", function(e) {
                console.log("Item eliminado.");
            });

            $(".dynamicform_wrapper_Product").on("limitReached", function(e, item) {
                alert("Límite de items alcanzado.");
            });

            $(".dynamicform_wrapper_Promotion").on("beforeInsert", function(e, item) {
                console.log("beforeInsert");
            });

            $(".dynamicform_wrapper_Promotion").on("afterInsert", function(e, item) {
                console.log("afterInsert");
            });

            $(".dynamicform_wrapper_Promotion").on("beforeDelete", function(e, item) {
                if (! confirm("¿Está seguro que desea eliminar este item?")) {
                    return false;
                }
                return true;
            });

            $(".dynamicform_wrapper_Promotion").on("afterDelete", function(e) {
                console.log("Item eliminado.");
            });

            $(".dynamicform_wrapper_Promotion").on("limitReached", function(e, item) {
                alert("Límite de items alcanzado.");
            });
        })
JS;
$this->registerJs($form_script);
?>