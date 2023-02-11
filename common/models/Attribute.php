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
            'type_id' => 'Тип',         // связь со справочником типов
            'name' => 'Название',
            'description' => 'Описание',
            'short_description' => 'Короткое описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(AttributeType::className(), ['id' => 'type_id']);
    }
}
