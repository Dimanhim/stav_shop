<?php

use backend\components\Helpers;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Catalogue;
use kartik\editors\Summernote;
use vova07\select2\Widget;

/** @var yii\web\View $this */
/** @var common\models\Catalogue $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="catalogue-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-6">
                <?php
                    $attributes = [
                        $form->field($model, 'parent_id')->dropDownList(Catalogue::getList(), ['prompt' => '[Не выбрано]', 'class' => 'form-control chosen']),
                        $form->field($model, 'name')->textInput(['maxlength' => true]),
                        $form->field($model, 'alias')->textInput(['maxlength' => true]),
                        $form->field($model, 'description')->widget(Summernote::className(), []),
                        $form->field($model, 'short_description')->widget(Summernote::className(), []),
                        $form->field($model, 'meta_description')->textarea(),
                        $form->field($model, 'meta_keywords')->textarea(),
                        $form->field($model, 'is_active')->checkbox(),
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
