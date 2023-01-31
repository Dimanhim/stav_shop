<?php

namespace common\models;

use backend\components\Helpers;
use Yii;

/**
 * This is the model class for table "stv_sellers".
 *
 * Продавцы
 * На случай, если товары будут выставляться от определенного продавца
 */
class Seller extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stv_sellers';
    }

    /**
     * @return string
     */
    public static function modelName()
    {
        return 'Продавцы';
    }

    /**
     * @return int
     */
    public static function typeId()
    {
        return Gallery::TYPE_SELLER;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return parent::rules() + [
            [['name'], 'required'],
            [['type', 'status_id'], 'integer'],
            [['name', 'phone', 'email', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'name' => 'Имя',
            'phone' => 'Телефон',
            'email' => 'E-mail',
            'address' => 'Адрес',
            'type' => 'Тип',                    // Пока не знаю для чего
            'status_id' => 'Статус',            // Пока не знаю для чего
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if($this->phone) {
            $this->phone = Helpers::setPhoneFormat($this->phone);
        }
        return parent::beforeSave($insert);
    }
}
