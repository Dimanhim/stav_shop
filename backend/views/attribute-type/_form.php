<?php

use backend\components\Helpers;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\AttributeType;

/** @var yii\web\View $this */
/** @var common\models\AttributeType $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="attribute-type-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-6">
                <?php
                    $attributes = [
                        $form->field($model, 'parent_id')->dropDownList(AttributeType::getList(), ['prompt' => '[Не выбрано]']),
                        $form->field($model, 'name')->textInput(['maxlength' => true]),
                        $form->field($model, 'description')->textarea(['rows' => 6]),
                        $form->field($model, 'short_description')->textarea(['rows' => 6]),
                        $form->field($model, 'is_active')->checkbox()
                    ];
                    echo $model->getFormCard($attributes, 'Основная информация');
                ?>
            </div>
            <div class="col-md-6">
                <?= $model->getImagesField($form) ?>
            </div>
            <div class="col-12">
                <div class="form-group mt10">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
