<?php

use common\models\Attribute;
use common\models\AttributeType;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use himiklab\sortablegrid\SortableGridView;

/** @var yii\web\View $this */
/** @var backend\models\AttributeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attribute-index">

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
                'attribute' => 'attribute_types',
                'format' => 'raw',
                'value' => function($data) {
                    if($data->attributeTypes) {
                        return $data->getListLinksChunk($data->attributeTypes, 'attribute-type');
                    }
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'attribute_types',
                    'options' => ['placeholder' => '[не выбран]', 'multiple' => true],
                    'showToggleAll' => false,
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'data' => AttributeType::getList(),
                ]),
            ],
            'name',
            'short_description:ntext',
            [
                'attribute' => 'is_active',
                'format' => 'boolean',
                'filter' => [0 => 'Нет', 1 => 'Да'],
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Attribute $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
