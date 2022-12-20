<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stv_products".
 *
 * Продукты (услуги)
 *
 */
class Product extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stv_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return parent::rules() + [
            [['unique_id', 'name'], 'required'],
            [['catalogue_id', 'type', 'cost_full', 'cost_old', 'cost_discount', 'discount', 'is_active', 'deleted', 'position', 'created_at', 'updated_at'], 'integer'],
            [['description', 'short_description', 'attributes'], 'string'],
            [['unique_id', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'catalogue_id' => 'Каталог',
            'type' => 'Тип',                // Поле не нужно
            'name' => 'Название',
            'description' => 'Описание',
            'short_description' => 'Короткое описание',
            'cost_full' => 'Цена',
            'cost_old' => 'Старая цена',
            'cost_discount' => 'Цена со скидкой',
            'discount' => 'Скидка в %',
            'attributes' => 'Атрибуты',     // Связь со справочником
        ];
    }
}
