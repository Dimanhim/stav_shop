<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stv_attributes".
 *
 * @property int $id
 * @property string $unique_id
 * @property int|null $type_id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $short_description
 * @property int|null $is_active
 * @property int|null $deleted
 * @property int|null $position
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Attribute extends \common\models\BaseModel
{
    public $attribute_types;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stv_attributes';
    }

    /**
     * @return string
     */
    public static function modelName()
    {
        return 'Атрибуты';
    }

    /**
     * @return int
     */
    public static function typeId()
    {
        return Gallery::TYPE_ATTRIBUTE;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return parent::rules() + [
            [['name'], 'required'],
            [['description', 'short_description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['attribute_types'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'name' => 'Название',
            'attribute_types' => 'Типы атрибутов',
            'description' => 'Описание',
            'short_description' => 'Короткое описание',
        ];
    }

    public function afterFind()
    {
        if($this->attributeTypes) {
            foreach($this->attributeTypes as $attributeType) {
                $this->attribute_types[] = $attributeType->id;
            }
        }
        return parent::afterFind();
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if($this->attribute_types) {
            AttributeTypeRelation::deleteAll(['attribute_id' => $this->id]);
            foreach($this->attribute_types as $attributeType) {
                $model = new AttributeTypeRelation();
                $model->attribute_id = $this->id;
                $model->attribute_type_id = $attributeType;
                $model->save();
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getAttributeTypes()
    {
        if($relations = AttributeTypeRelation::findModels()->andWhere(['attribute_id' => $this->id])->all()) {
            $typeIds = [];
            foreach($relations as $relation) {
                $typeIds[] = $relation->attribute_type_id;
            }
            return AttributeType::findModels()->andWhere(['in', 'id', $typeIds])->all();
        }
        return [];
    }
}
