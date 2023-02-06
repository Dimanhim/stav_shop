<?php

use common\models\Catalogue;
use common\models\Page;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use himiklab\sortablegrid\SortableGridView;

/** @var yii\web\View $this */
/** @var backend\models\PageSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!--
    <p>
        <?//= Html::a('Добавить', ['create', 'type' => $type], ['class' => 'btn btn-success']) ?>
    </p>
    -->

    <?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'image_fields',
                'format' => 'raw',
                'value' => function($data) {
                    return $data->dataSource ? $data->dataSource->mainImageHtml : '';
                }
            ],
            'name',
            [
                'attribute' => 'alias',
                'format' => 'raw',
                'value' => function($data) {
                    return Html::a($data->alias, $data->fullUri, ['target' => '_blanc']);
                }
            ],
            [
                'attribute' => 'type',
                'format' => 'raw',
                /*'value' => function($data) {
                    return Html::a($data->alias, $data->fullUri, ['target' => '_blanc']);
                },*/
                'filter' => Page::avaliableTypes()
            ],
            [
                'attribute' => 'parent_id',
                'format' => 'raw',
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
                    'data' => Page::getList(),
                ]),
            ],
            [
                'attribute' => 'is_active',
                'format' => 'boolean',
                'filter' => [0 => 'Нет', 1 => 'Да'],
            ],
            //'relation_id',
            //'h1',
            //'title',
            //'meta_description',
            //'meta_keywords',
            //'template',
            //'custom_code:ntext',
            //'is_active',
            //'deleted',
            //'position',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Page $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
