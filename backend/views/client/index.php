<?php

use common\models\Client;
use himiklab\thumbnail\EasyThumbnailImage;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\ClientSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">

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
            'phone',
            'email:email',
            'address',
            //'type',
            //'status_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Client $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
