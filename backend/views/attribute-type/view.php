<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\AttributeType $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->modelName, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="attribute-type-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить?',
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
                'format' => 'raw',
                'value' => function($data) {
                    if($data->parent) return Html::a($data->parent->name, ['attribute-type/view', 'id' => $data->parent->id]);
                }
            ],
            'name',
            'description:ntext',
            'short_description:ntext',

            [
                'attribute' => 'image_fields',
                'format' => 'raw',
                'value' => function($data) {
                    return $data->imagesHtml;
                }
            ],
            [
                'attribute' => 'is_active',
                'value' => function($data) {
                    return $data->active;
                }
            ],
            [
                'attribute' => 'created_at',
                'value' => function($data) {
                    return $data->createdAt;
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function($data) {
                    return $data->updatedAt;
                }
            ],
        ],
    ]) ?>

</div>
