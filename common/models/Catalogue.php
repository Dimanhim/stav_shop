<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stv_catalogue".
 *
 * Каталог
 *
 */
class Catalogue extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stv_catalogue';
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
}
