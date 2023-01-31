<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Catalogue $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->modelName, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="catalogue-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить категорию?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'parent_id',
                'value' => function($data) {
                    if($data->parent) return $data->parent->name;
                }
            ],
            'name',
            [
                'attribute' => 'description',
                'format' => 'raw',
                'value' => function($data) {
                    return $data->description;
                }
            ],
            [
                'attribute' => 'short_description',
                'format' => 'raw',
                'value' => function($data) {
                    return $data->short_description;
                }
            ],


            [
                'attribute' => 'image_fields',
                'format' => 'raw',
                'value' => function($data) {
                    if($data->gallery) return $data->gallery->getPreviewListHTML();
                }
            ],
            [
                'attribute' => 'is_active',
                'value' => function($data) {
                    return $data->is_active ? 'Да' : 'Нет';
                }
            ],
            [
                'attribute' => 'created_at',
                'value' => function($data) {
                    return date('d.m.Y H:i', $data->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function($data) {
                    return date('d.m.Y H:i', $data->updated_at);
                }
            ],
        ],
    ]) ?>

</div>
