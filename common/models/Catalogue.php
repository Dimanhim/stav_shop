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
            [['name', 'alias', 'meta_description', 'meta_keywords'], 'string', 'max' => 255],
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
            'alias' => 'Алиас',
            'description' => 'Описание',
            'short_description' => 'Короткое описание',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id'])->andWhere(['is_active' => 1])->andWhere(['is', 'deleted', null]);
    }

    /**
     * @return string
     */
    public function getFullUri() {
        $fullPath = [];
        $page = $this;

        if ($page->alias == '/') {
            return '/';
        }

        do {
            $fullPath[] = $page->alias;
            if ($page->parent_id) {
                $page = $page->parent;
            } else {
                $page = null;
            }
        } while ($page);

        return '/'.implode('/', array_reverse($fullPath));
    }

}
