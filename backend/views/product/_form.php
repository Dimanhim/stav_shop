<?php

use himiklab\thumbnail\EasyThumbnailImage;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Catalogue;
use common\models\Product;
use kartik\widgets\FileInput;

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
                        <?= $form->field($model, 'catalogue_id')->dropDownList(Catalogue::getList(), ['prompt' => '[Не выбрано]', 'class' => 'form-control chosen']) ?>
                        <?= $form->field($model, 'type')->dropDownList(Product::getTypes(), ['prompt' => '[Не выбрано]', 'class' => 'form-control chosen']) ?>
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
                        <?= $form->field($model, 'short_description')->textarea(['rows' => 6]) ?>
                        <?= $form->field($model, 'is_active')->checkbox() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card mb10">
                <div class="card-header">
                    Цены
                </div>
                <div class="card-body">
                    <?= $form->field($model, 'cost_full')->textInput() ?>
                    <?= $form->field($model, 'cost_old')->textInput() ?>
                    <?= $form->field($model, 'cost_discount')->textInput() ?>
                    <?= $form->field($model, 'discount')->textInput() ?>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Изображения
                </div>
                <div class="card-body">
                    <?php if ($model->gallery) echo $model->gallery->getPreviewListHTML() ?>
                    <?= $form->field($model, 'image_fields[]')->widget(FileInput::classname(), [
                        'options' => [
                            'accept' => 'image/*',
                            'multiple' => true
                        ],
                        'pluginOptions' => [
                            'browseLabel' => 'Выбрать',
                            'showPreview' => false,
                            'showUpload' => false,
                            'showRemove' => false,
                        ]
                    ]) ?>
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
