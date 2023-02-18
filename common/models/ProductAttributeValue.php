<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stv_product_attribute_values".
 *
 * Справочник
 * значений атрибутов товаров
 * с привязкой к типам
 * (Атрибуты одного типа, к примеру? размеры одежды 44,46,50)
 *
 */
class ProductAttributeValue extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stv_product_attribute_values';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return parent::rules() + [
            [['name'], 'required'],
            [['type_id'], 'integer'],
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
            'type_id' => 'Тип',         // привязка к ProductAttributeTypes
            'name' => 'Название',
            'description' => 'Описание',
            'short_description' => 'Короткое описание',
        ];
    }

    /**
     * Связь с таблицей типов атрибутов товаров
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeType()
    {
        return $this->hasOne(ProductAttributeType::className(), ['id' => 'type_id'])->andWhere(['is_active' => 1])->andWhere(['is', 'deleted', null]);
    }
}
