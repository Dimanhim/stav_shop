<?php

use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Catalogue;
use common\models\Product;
use common\models\Tag;
use kartik\widgets\FileInput;
use common\models\Client;

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
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    Основная информация
                </div>
                <div class="card-body">
                    <div class="card-text">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'qty')->textInput() ?>
                        <?= $form->field($model, 'client_id')->dropDownList(Client::getList(), ['prompt' => '[Не выбрано]', 'class' => 'form-control chosen']) ?>
                        <?= $form->field($model, 'catalogue_id')->dropDownList(Catalogue::getList(), ['prompt' => '[Не выбрано]', 'class' => 'form-control chosen']) ?>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Изображения
                </div>
                <div class="card-body">
                    <?php if (!$model->isNewRecord && $model->gallery) echo $model->gallery->getPreviewListHTML() ?>
                    <?= $form->field($model, 'image_fields[]')->widget(FileInput::classname(), [
                        'options' => [
                            'accept' => 'image/*',
                            'multiple' => true
                        ],
                        'pluginOptions' => [
                            'browseLabel' => 'Выбрать',
                            //'showPreview' => false,
                            //'showUpload' => false,
                            //'showRemove' => false,
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    Дополнительная информация
                </div>
                <div class="card-body">
                    <div class="card-text">
                        <?= $form->field($model, 'tags')->widget(Select2::classname(), [
                            'data' => Tag::getList(),
                            'options' => ['placeholder' => '[не выбраны]', 'multiple' => true],
                            'showToggleAll' => false,
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]) ?>
                        <?= $form->field($model, 'type')->dropDownList(Product::getTypes(), ['prompt' => '[Не выбрано]', 'class' => 'form-control chosen']) ?>


                        <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
                        <?= $form->field($model, 'short_description')->textarea(['rows' => 2]) ?>
                        <?= $form->field($model, 'note')->textarea(['rows' => 2]) ?>
                        <?= $form->field($model, 'is_active')->checkbox() ?>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Цены
                </div>
                <div class="card-body">
                    <?= $form->field($model, 'cost_full')->textInput() ?>
                    <?= $form->field($model, 'cost_old')->textInput() ?>
                    <?= $form->field($model, 'cost_discount')->textInput() ?>
                    <?= $form->field($model, 'discount')->textInput() ?>
                    <?= $form->field($model, 'delivery_price')->textInput() ?>
                    <?= $form->field($model, 'delivery_time')->textInput(['class' => 'form-control select-time']) ?>
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
