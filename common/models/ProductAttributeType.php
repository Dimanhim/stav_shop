<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stv_product_attribute_types".
 *
 * @property int $id
 * @property string $unique_id
 * @property int $attribute_type_id
 * @property int $product_id
 * @property string|null $description
 * @property string|null $short_description
 * @property int|null $is_active
 * @property int|null $deleted
 * @property int|null $position
 * @property int|null $created_at
 * @property int|null $updated_at
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
            [['attribute_type_id', 'product_id'], 'required'],
            [['attribute_type_id', 'product_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'id' => 'ID',
            'unique_id' => 'Unique ID',
            'attribute_type_id' => 'Attribute Type ID',
            'product_id' => 'Product ID',
            'is_active' => 'Is Active',
            'deleted' => 'Deleted',
            'position' => 'Position',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
    public function getProductAttributeType()
    {
        return $this->hasOne(AttributeType::className(), ['id' => 'attribute_type_id'])->andWhere(['is_active' => 1])->andWhere(['is', 'deleted', null]);
    }
}
