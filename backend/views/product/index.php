<?php

use common\models\Product;
use himiklab\thumbnail\EasyThumbnailImage;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'catalogue_id',
                'format' => 'raw',
                'value' => function($data) {
                    if($data->catalogue) return Html::a($data->catalogue->name, ['catalogue/view', 'id' => $data->catalogue->id]) ;
                }
            ],
            [
                'attribute' => 'image_fields',
                'format' => 'raw',
                'value' => function($data) {
                    if($data->mainImage) return Html::a(
                            EasyThumbnailImage::thumbnailImg(Yii::getAlias('@upload').$data->mainImage->path, 100, 100, EasyThumbnailImage::THUMBNAIL_OUTBOUND),
                            EasyThumbnailImage::thumbnailFileUrl(Yii::getAlias('@upload').$data->mainImage->path, 1000, 1000, EasyThumbnailImage::THUMBNAIL_OUTBOUND),
                            ['data-fancybox' => 'gallery']
                    ) ;
                }
            ],
            'name',
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
            [
                'attribute' => 'note',
                'value' => function($data) {
                    return $data->note ? 'Да' : 'Нет';
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
