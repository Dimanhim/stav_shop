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
        return 'Атрибуты товаров';
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
}
