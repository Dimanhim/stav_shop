<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Catalogue $model */

$this->title = 'Добавление';
$this->params['breadcrumbs'][] = ['label' => $model->modelName, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalogue-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
