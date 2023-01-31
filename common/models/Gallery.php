<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stv_galleries".
 *
 * @property int $id
 * @property string $unique_id
 * @property string $name
 * @property string|null $description
 * @property string|null $short_description
 * @property int|null $object_id
 * @property int|null $object_type
 * @property int|null $is_active
 * @property int|null $deleted
 * @property int|null $position
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Gallery extends \common\models\BaseModel
{
    const TYPE_CATALOGUE       = 1;
    const TYPE_PRODUCT         = 2;
    const TYPE_IMAGE           = 3;
    const TYPE_CLIENT          = 4;
    const TYPE_TAG             = 5;
    const TYPE_PAGE            = 6;
    const TYPE_PAGE_CONTENT    = 7;
    const TYPE_SELLER          = 8;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stv_galleries';
    }

    /**
     * @return string
     */
    public static function modelName()
    {
        return 'Галереи';
    }

    /**
     * @return string
     */
    public static function typeName()
    {
        return 'gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return parent::rules() + [
            [['description', 'short_description'], 'string'],
            [['object_id', 'object_type'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'name' => 'Name',
            'description' => 'Description',
            'short_description' => 'Short Description',
            'object_id' => 'Object ID',
            'object_type' => 'Object Type',
        ];
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [
            self::TYPE_CATALOGUE => 'Категории',
            self::TYPE_PRODUCT   => 'Товары',
            self::TYPE_IMAGE     => 'Изображения',
            self::TYPE_CLIENT    => 'Клиенты',
            self::TYPE_TAG       => 'Теги',
            self::TYPE_PAGE      => 'Страницы',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['gallery_id' => 'id'])->orderBy(['position' => SORT_ASC]);
    }

    public function getPreviewListHTML()
    {
        return Yii::$app->controller->renderPartial('//chunks/_gallery_preview_list', [
            'model' => $this
        ]);
    }
}
