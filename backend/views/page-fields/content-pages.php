<?php

use common\models\ContentPage;
use himiklab\thumbnail\EasyThumbnailImage;
use kartik\editors\Summernote;
use kartik\file\FileInput;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model ContentPage */
/* @var $form ActiveForm */
?>

<div class="card">
    <div class="card-header">
        Информация о странице
    </div>
    <div class="card-body">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control page-name']) ?>
        <?= $form->field($model, 'content')->widget(Summernote::className(), []) ?>
    </div>
</div>
<div class="card">
    <div class="card-header">
        Изображения
    </div>
    <div class="card-body">
        <?php if ($model->gallery) echo $model->gallery->getPreviewListHTML() ?>
        <?= $form->field($model, 'image_fields[]')->widget(\kartik\widgets\FileInput::classname(), [
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



