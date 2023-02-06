<?php

use common\models\Page;
use kartik\select2\Select2;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Page $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'default-form'
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-7">
            <?= $this->render("/page-fields/{$page->type}", [
                'model' => $model,
                'form' => $form,
            ]) ?>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    Основная информация
                </div>
                <div class="card-body">
                    <?= $form->field($page, 'alias')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($page, 'parent_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Page::getList(), 'id', 'name'),
                        'options' => ['placeholder' => 'Не указан'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
                    <?= $form->field($page, 'name')->textInput(['maxlength' => true, 'class' => 'form-control page-name']) ?>
                    <?= $form->field($page, 'type')->dropDownList(Page::avaliableTypes(), ['prompt' => '[Не выбрано]']) ?>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    SEO
                </div>
                <div class="card-body">
                    <?= $form->field($page, 'h1')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($page, 'title')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($page, 'meta_description')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($page, 'meta_keywords')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Дополнительная информация
                </div>
                <div class="card-body">
                    <?= $form->field($page, 'template')->dropDownList(Page::customTemplates(), ['prompt' => '[Не выбрано]']) ?>
                    <?= $form->field($page, 'custom_code')->textarea(['rows' => 10]) ?>

                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?php if (!$page->isNewRecord): ?>
            <?= Html::a('Перейти', $page->getFullUri(), ['class' => 'btn btn-primary', 'target' => '_blank']) ?>
        <?php endif ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
