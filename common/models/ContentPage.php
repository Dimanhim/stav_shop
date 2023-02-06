<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stv_content_pages".
 *
 * @property int $id
 * @property string $unique_id
 * @property int|null $name
 * @property string|null $content_code
 * @property int|null $is_active
 * @property int|null $deleted
 * @property int|null $position
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class ContentPage extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stv_content_pages';
    }

    /**
     * @return string
     */
    public static function modelName()
    {
        return 'Страницы контента';
    }

    /**
     * @return int
     */
    public static function typeId()
    {
        return Gallery::TYPE_PAGE_CONTENT;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return parent::rules() + [
            [['name'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'name' => 'Название',
            'content' => 'Контент',
        ];
    }
}
