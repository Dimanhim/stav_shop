<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Page $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $page->modelName, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->modelName, 'url' => ['index', 'type' => $page->type]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="page-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'unique_id',
            'name',
            'alias',
            'type',
            'parent_id',
            'relation_id',
            'h1',
            'title',
            'meta_description',
            'meta_keywords',
            'template',
            'custom_code:ntext',
            'is_active',
            'deleted',
            'position',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
