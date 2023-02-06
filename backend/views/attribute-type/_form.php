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
            <div class="card">
                <div class="card-header">
                    Основная информация
                </div>
                <div class="card-body">
                    <div class="card-text">
                        <?= $form->field($model, 'parent_id')->dropDownList(AttributeType::getList(), ['prompt' => '[Не выбрано]']) ?>
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
                        <?= $form->field($model, 'short_description')->textarea(['rows' => 6]) ?>
                        <?= $form->field($model, 'is_active')->checkbox() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Изображения
                </div>
                <div class="card-body">
                    <?php if (!$model->isNewRecord && $model->gallery) echo $model->gallery->getPreviewListHTML() ?>
                    <?= $form->field($model, 'image_fields[]')->widget(FileInput::classname(), Helpers::getFileInputOptions()) ?>
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
