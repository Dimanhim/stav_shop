<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Seller $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->modelName, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="seller-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Уверены, что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'phone',
            'email:email',
            'address',
            //'type',
            //'status_id',
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
