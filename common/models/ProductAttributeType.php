<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stv_product_attribute_types".
 *
 * Справочник
 * типов атрибутов товаров
 * (к примеру, размер одежды, цвет, марка автомобиля и т.д.)
 *
 */
class ProductAttributeType extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stv_product_attribute_types';
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
}
