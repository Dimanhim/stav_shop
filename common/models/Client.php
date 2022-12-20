<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stv_clients".
 *
 * Клиенты
 *
 */
class Client extends \common\models\BaseModel
{
    const STATUS_ONE_TIME = 1;
    const STATUS_REGULAR  = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stv_clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return parent::rules() + [
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
            'name' => 'ФИО',
            'phone' => 'Номер телефона',
            'email' => 'E-mail',
            'address' => 'Адрес',
            'type' => 'Тип',                    // Пока непонятно для чего
            'status_id' => 'Статус',
        ];
    }

    /**
     * @return array
     */
    public function getStatuses()
    {
        return [
            self::STATUS_ONE_TIME => 'Однократный',
            self::STATUS_REGULAR  => 'Постоянный',
        ];
    }
}
