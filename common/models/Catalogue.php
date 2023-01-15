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
     * @return string
     */
    public static function modelName()
    {
        return 'Категории';
    }

    /**
     * @return int
     */
    public static function typeId()
    {
        return Gallery::TYPE_CATALOGUE;
    }

    /**
     * @return string
     */
    /*public static function typeName()
    {
        return 'catalogue';
    }*/

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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

}
