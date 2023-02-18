<?php

use kartik\widgets\Select2;
use backend\components\Helpers;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Catalogue;
use common\models\Product;
use common\models\Tag;
use kartik\widgets\FileInput;
use common\models\Seller;
use common\models\Attribute;
use common\models\AttributeType;

/** @var yii\web\View $this */
/** @var common\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">
    <?php $form = ActiveForm::begin([
            /*'fieldConfig' => [
                'template' => "<div class=\"form-floating\">{input}\n{label}\n{error}</div>"
            ],*/
    ]); ?>
    <div class="row">
        <div class="col-4">
            <?php
                $attributes = [
                    $form->field($model, 'name')->textInput(['maxlength' => true]),
                    $form->field($model, 'alias')->textInput(['maxlength' => true]),
                    $form->field($model, 'qty')->textInput(),
                    $form->field($model, 'seller_id')->dropDownList(Seller::getList(), ['prompt' => '[Не выбрано]', 'class' => 'form-control chosen']),
                    $form->field($model, 'catalogue_id')->dropDownList(Catalogue::getList(), ['prompt' => '[Не выбрано]', 'class' => 'form-control chosen']),
                    $form->field($model, 'meta_description')->textarea(),
                    $form->field($model, 'meta_keywords')->textarea(),
                    $form->field($model, 'is_active')->checkbox()
                ];
                echo $model->getFormCard($attributes, 'Основная информация');
            ?>
            <?= $model->getImagesField($form) ?>
        </div>
        <div class="col-4">
            <?php
                $attributes = [
                    $form->field($model, 'type')->dropDownList(Product::getTypes(), ['prompt' => '[Не выбрано]', 'class' => 'form-control chosen']),
                    $form->field($model, 'description')->textarea(['rows' => 2]),
                    $form->field($model, 'short_description')->textarea(['rows' => 2]),
                    $form->field($model, 'note')->textarea(['rows' => 2]),
                    $form->field($model, 'tags')->widget(Select2::classname(), [
                            'data' => Tag::getList(),
                            'options' => ['placeholder' => '[не выбраны]', 'multiple' => true],
                            'showToggleAll' => false,
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]),
                ];
                echo $model->getFormCard($attributes, 'Дополнительная информация');
            ?>

        </div>
        <div class="col-4">
            <?php
                $attributes = [
                    $form->field($model, 'cost_full')->textInput(),
                    $form->field($model, 'cost_old')->textInput(),
                    $form->field($model, 'cost_discount')->textInput(),
                    $form->field($model, 'discount')->textInput(),
                    $form->field($model, 'delivery_price')->textInput(),
                    $form->field($model, 'delivery_time')->textInput(['class' => 'form-control select-time'])
                ];
                echo $model->getFormCard($attributes, 'Цены');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Типы атрибутов, атрибуты
                </div>
                <div class="card-body">

                    <?= $model->getAttributesTypesListHtml() ?>

                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group mt10">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
