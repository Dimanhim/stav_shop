<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stv_product_tags".
 *
 * @property int $id
 * @property string $unique_id
 * @property string $name
 * @property int|null $is_active
 * @property int|null $deleted
 * @property int|null $position
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Tag extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stv_tags';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return parent::rules() + [
            [['unique_id', 'name'], 'required'],
            [['unique_id', 'name'], 'string', 'max' => 255],
            [['description', 'short_description'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'name' => 'Название',
            'description' => 'Описание',
            'short_description' => 'Короткое описание',
        ];
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
}
