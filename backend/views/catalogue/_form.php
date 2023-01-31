<?php

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

    <?php $form = ActiveForm::begin([
        'id' => 'default-form',
        'enableAjaxValidation' => true,
    ]); ?>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    Основная информация
                </div>
                <div class="card-body">
                    <?= $form->field($model, 'parent_id')->dropDownList(Catalogue::getList(), ['prompt' => '[Не выбрано]', 'class' => 'form-control chosen']) ?>
                    <?/*= $form->field($model, 'parent_id')->widget(Widget::className(), [
                        'options' => [
                            'multiple' => false,
                            'placeholder' => 'Выбрать',
                            'prompt' => '[Не выбрано]',
                        ],
                        'items' => Catalogue::getList(),
                    ])*/ ?>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'description')->widget(Summernote::className(), []) ?>
                    <?= $form->field($model, 'short_description')->widget(Summernote::className(), []) ?>
                    <?= $form->field($model, 'is_active')->checkbox() ?>
                </div>
            </div>


            <div class="col-12">
                <div class="form-group mt10">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
