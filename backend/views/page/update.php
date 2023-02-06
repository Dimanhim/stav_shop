<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Page $model */

$this->title = 'Редактирование: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => $page->modelName, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->modelName, 'url' => ['index', 'type' => $page->type]];
$this->params['breadcrumbs'][] = ['label' => $page->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="page-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'page' => $page,
        'model' => $model,
    ]) ?>

</div>
