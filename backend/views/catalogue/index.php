<?php

use common\models\Catalogue;
use himiklab\thumbnail\EasyThumbnailImage;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use himiklab\sortablegrid\SortableGridView;
use kartik\widgets\Select2;

/** @var yii\web\View $this */
/** @var backend\models\CatalogueSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalogue-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                'attribute' => 'parent_id',
                'value' => function($data) {
                    if($data->parent) return $data->parent->name;
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'parent_id',
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
                'attribute' => 'alias',
                'format' => 'raw',
                'value' => function($data) {
                    return Html::a('На сайте', $data->fullUri, ['target' => '_blanc']);
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
                'urlCreator' => function ($action, Catalogue $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
