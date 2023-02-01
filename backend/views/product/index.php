<?php

use common\models\Catalogue;
use common\models\Product;
use himiklab\thumbnail\EasyThumbnailImage;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use himiklab\sortablegrid\SortableGridView;

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

    <?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'image_fields',
                'format' => 'raw',
                'value' => function($data) {
                    return $data->mainImageHtml;
                }
            ],
            [
                'attribute' => 'catalogue_id',
                'format' => 'raw',
                'value' => function($data) {
                    if($data->catalogue) return Html::a($data->catalogue->name, ['catalogue/view', 'id' => $data->catalogue->id]) ;
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'catalogue_id',
                    'options' => ['placeholder' => '[не выбран]', 'multiple' => true],
                    'showToggleAll' => false,
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'data' => Catalogue::getList(),
                ]),
            ],

            'name',
            [
                'attribute' => 'seller_id',
                'format' => 'raw',
                'value' => function($data) {
                    if($data->seller) return Html::a($data->seller->name, ['seller/view', 'id' => $data->seller->id]) ;
                }
            ],
            'qty',
            'cost_full',
            'cost_discount',
            'discount',
            [
                'attribute' => 'note',
                'value' => function($data) {
                    return $data->note ? 'Да' : 'Нет';
                }
            ],
            [
                'attribute' => 'is_active',
                'value' => function($data) {
                    return $data->active;
                },
                'filter' => [0 => 'Нет', 1 => 'Да'],
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
