<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stv_attribute_type_relations".
 *
 * @property int $id
 * @property string $unique_id
 * @property int|null $attribute_id
 * @property int|null $attribute_type_id
 * @property int|null $is_active
 * @property int|null $deleted
 * @property int|null $position
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class AttributeTypeRelation extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stv_attribute_type_relations';
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
            [['attribute_id', 'attribute_type_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'attribute_id' => 'Attribute ID',
            'attribute_type_id' => 'Attribute Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeValue()
    {
        return $this->hasOne(Attribute::className(), ['id' => 'attribute_id'])->andWhere(['is_active' => 1])->andWhere(['is', 'deleted', null]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeType()
    {
        return $this->hasOne(AttributeType::className(), ['id' => 'attribute_type_id'])->andWhere(['is_active' => 1])->andWhere(['is', 'deleted', null]);
    }
}
