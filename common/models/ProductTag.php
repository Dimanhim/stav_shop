<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stv_product_tags".
 *
 * @property int $id
 * @property string $unique_id
 * @property int|null $product_id
 * @property int|null $tag_id
 * @property int|null $is_active
 * @property int|null $deleted
 * @property int|null $position
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class ProductTag extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stv_product_tags';
    }

    /**
     * @return string
     */
    public static function modelName()
    {
        return 'Тэги товаров';
    }

    /**
     * @return int
     */
    public static function typeId()
    {
        return Gallery::TYPE_TAG;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return parent::rules() + [
            [['product_id', 'tag_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'product_id' => 'Product ID',
            'tag_id' => 'Tag ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id'])->andWhere(['is_active' => 1])->andWhere(['is', 'deleted', null]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id'])->andWhere(['is_active' => 1])->andWhere(['is', 'deleted', null]);
    }
}
