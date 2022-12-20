<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stv_images".
 *
 * Изображения
 *
 */
class Image extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stv_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return parent::rules() + [
            [['description', 'short_description'], 'string'],
            [['gallery_id'], 'integer'],
            [['name', 'path'], 'string', 'max' => 255],
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
            'path' => 'Путь',
            'gallery_id' => 'Галерея',
        ];
    }
}
