<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Product $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->modelName, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

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
                'attribute' => 'catalogue_id',
                'format' => 'raw',
                'value' => function($data) {
                    if($data->catalogue) return Html::a($data->catalogue->name, ['catalogue/view', 'id' => $data->catalogue->id]) ;
                }
            ],
            'name',
            'description:ntext',
            'short_description:ntext',
            [
                'attribute' => 'client_id',
                'format' => 'raw',
                'value' => function($data) {
                    if($data->client) return Html::a($data->client->name, ['client/view', 'id' => $data->client->id]) ;
                }
            ],
            'qty',
            'cost_full',
            'cost_old',
            'cost_discount',
            'discount',
            'delivery_price',
            'delivery_time',

            [
                'attribute' => 'tags',
                'format' => 'raw',
                'value' => function($data) {
                    return $data->getTagsChunk();
                }
            ],
            'note:ntext',


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
