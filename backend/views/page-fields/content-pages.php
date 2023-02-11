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

<?php
    $attributes = [
        $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control page-name']),
        $form->field($model, 'content')->widget(Summernote::className(), []),
    ];
    echo $model->getFormCard($attributes, 'Информация о странице');
?>
<?= $model->getImagesField($form) ?>



