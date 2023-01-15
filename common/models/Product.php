<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stv_products".
 *
 * Продукты (услуги)
 *
 * Поменять TYPE_DEFAULT
 */
class Product extends \common\models\BaseModel
{

    const TYPE_DEFAULT = 1;
    const TYPE_PRODUCT = 1;
    const TYPE_SERVICE = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stv_products';
    }

    /**
     * @return string
     */
    public static function modelName()
    {
        return 'Товары';
    }

    /**
     * @return int
     */
    public static function typeId()
    {
        return Gallery::TYPE_PRODUCT;
    }

    /**
     * @return string
     */
    /*public static function typeName()
    {
        return 'product';
    }*/

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return parent::rules() + [
            [['name'], 'required'],
            [['catalogue_id', 'type', 'cost_full', 'cost_old', 'cost_discount', 'discount'], 'integer'],
            [['description', 'short_description', 'attributes'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'catalogue_id' => 'Каталог',
            'type' => 'Тип',                // Продукт/Услуга
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

    public function beforeSave($insert)
    {
        if(!$this->type) {
            $this->type = self::TYPE_PRODUCT;
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogue()
    {
        return $this->hasOne(Catalogue::className(), ['id' => 'catalogue_id']);
    }

    public static function getTypes()
    {
        return [
            self::TYPE_PRODUCT => 'Продукт',
            self::TYPE_SERVICE => 'Услуга',
        ];
    }
}
