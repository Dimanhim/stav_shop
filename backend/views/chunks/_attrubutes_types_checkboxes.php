<?php

use common\models\AttributeType;
use yii\helpers\Html;

?>
    <?php if($tree = AttributeType::buildTree()) : ?>
        <ul class="attribute-type-list">
            <?php foreach($tree as $item) : ?>
                <li>
                    <label for="input-<?= $item->id ?>">
                        <?php $modelName = Html::getInputName($model, 'product_attribute_types[]') ?>
                        <?= Html::checkbox($modelName, false, ['id' => 'input-'.$item->id, 'value' => $item->id]) ?>
                        <?= $item->name ?>
                        <?php if($childs = $item->childs) : ?>
                            <ul class="attribute-type-sublist">
                                <?php foreach($childs as $subItem) : ?>
                                    <li>
                                        <label for="input-<?= $subItem->id ?>">
                                            <?= Html::checkbox($modelName, false, ['id' => 'input-'.$subItem->id, 'value' => $subItem->id]) ?>
                                            <?= $subItem->name ?>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </label>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

