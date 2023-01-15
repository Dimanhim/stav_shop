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
     * @return string
     */
    public static function modelName()
    {
        return 'Изображения';
    }

    /**
     * @return int
     */
    public static function typeId()
    {
        return Gallery::TYPE_IMAGE;
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

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        if (file_exists(Yii::getAlias('@upload').$this->path)) {
            unlink(Yii::getAlias('@upload').$this->path);
        }
        return parent::beforeDelete();
    }

    /**
     * @param $path
     * @return Image
     */
    public static function create($path, $galleryId = null) {
        $image = new self();
        $image->path = $path;
        if($galleryId) $image->gallery_id = $galleryId;
        $image->save();
        return $image;
    }
}
