<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Типы атрибутов товаров
 * (к примеру, размер одежды, цвет, марка автомобиля и т.д.)
 */
class AttributeType extends \common\models\BaseModel
{
    public $childs;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stv_attribute_types';
    }

    /**
     * @return string
     */
    public static function modelName()
    {
        return 'Типы атрибутов';
    }

    /**
     * @return int
     */
    public static function typeId()
    {
        return Gallery::TYPE_ATTRIBUTE_TYPE;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return parent::rules() + [
            [['name'], 'required'],
            [['parent_id'], 'integer'],
            [['description', 'short_description'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'parent_id' => 'Родитель',
            'name' => 'Название',
            'description' => 'Описание',
            'short_description' => 'Короткое описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    /**
     * @return array|\yii\db\ActiveQuery
     */
    public function getAttributeValues()
    {
        if($relations = AttributeTypeRelation::find()->where(['attribute_type_id' => $this->id])->all()) {
            $attributeIds = [];
            foreach($relations as $relation) {
                $attributeIds[] = $relation->attribute_id;
            }
            return Attribute::find()->where(['in', 'id', $attributeIds])->all();
        }
        return [];
        return $this->hasMany(Attribute::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(self::className(), ['parent_id' => 'id']);
    }

    /**
     * возвращает список ссылок на дочерние элементы
     * @return string
     */
    public function getChildrenItemsHtml()
    {
        if($models = $this->children) {
            return Yii::$app->controller->renderPartial('//chunks/_list_links', [
                'models' => $models,
                'link' => 'attribute-type',
            ]);
        }
    }

    /**
     * возвращает список ссылок на дочерние элементы
     * @return string
     */
    public function getAttributesHtml()
    {
        if($models = $this->attributeValues) {
            return Yii::$app->controller->renderPartial('//chunks/_list_links', [
                'models' => $models,
                'link' => 'attribute',
            ]);
        }
    }

    public static function getTree()
    {
        if($lists = self::getList()) {
            foreach($lists as $list) {
                //if()
            }
        }
        $result = [
            1 => 'Атрибут 1',
            2 => 'Атрибут 2',
            3 => [
                4 => 'Атрибут 6',
                5 => 'Атрибут 5',
            ],
            'что то 6' => [
                7 => 'Атрибут 6',
                8 => 'Атрибут 5',
            ],
        ];
        return $result;
    }

    public static function buildTree()
    {
        $tree = [];
        if($models = self::findModels()->indexBy('id')->all()) {
            foreach ($models as $id=>&$node) {
                if (!$node->parent_id)
                    $tree[$id] = &$node;
                else
                    $models[$node->parent_id]->childs[$node->id] = &$node;
            }
        }
        return $tree;
    }
}
