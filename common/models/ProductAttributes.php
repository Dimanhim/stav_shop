<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stv_product_attributes".
 *
 * Таблица связей
 * между имеющимися в справочнике атрибутами и товарами
 * (привязка к справочнику отдельных атрибутов (ProductAttributeValue), к примеру, у данного товара имеются размеры одежды 46, 50)
 *
 */
class ProductAttributes extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stv_product_attributes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return parent::rules() + [
            [['attribute_id', 'product_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'attribute_id' => 'Атрибут',
            'product_id' => 'Продукт',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id'])->andWhere(['is_active' => 1])->andWhere(['is', 'deleted', null]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttribute()
    {
        return $this->hasOne(Attribute::className(), ['id' => 'attribute_id'])->andWhere(['is_active' => 1])->andWhere(['is', 'deleted', null]);
    }
}
