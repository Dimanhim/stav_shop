<?php

use backend\components\Helpers;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Seller $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="seller-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-6">
            <?php
                $attributes = [
                    $form->field($model, 'name')->textInput(['maxlength' => true]),
                    $form->field($model, 'phone')->textInput(['maxlength' => true, 'class' => 'form-control phone-mask']),
                    $form->field($model, 'email')->textInput(['maxlength' => true]),
                    $form->field($model, 'address')->textInput(['maxlength' => true]),
                    $form->field($model, 'is_active')->checkbox(),
                    //$form->field($model, 'type')->textInput(),
                    //$form->field($model, 'status_id')->textInput()
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
