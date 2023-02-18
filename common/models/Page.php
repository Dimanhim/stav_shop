<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stv_pages".
 *
 * @property int $id
 * @property string $unique_id
 * @property int|null $name
 * @property int|null $alias
 * @property string|null $type
 * @property int|null $parent_id
 * @property int|null $relation_id
 * @property string|null $h1
 * @property string|null $title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $template
 * @property string|null $custom_code
 * @property int|null $is_active
 * @property int|null $deleted
 * @property int|null $position
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Page extends \common\models\BaseModel
{
    const TYPE_CONTENT = 'content-pages';

    public static $current;

    public static $availableTypes = [
        self::TYPE_CONTENT => [
            'class' => ContentPage::class,
            'title' => 'Страницы контента',
            'imagePath' => 'Страницы контента',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stv_pages';
    }

    /**
     * @return string
     */
    public static function modelName()
    {
        return 'Страницы';
    }

    /**
     * @return int
     */
    public static function typeId()
    {
        return Gallery::TYPE_PAGE;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return parent::rules() +  [
            [['alias'], 'unique'],
            [['parent_id', 'relation_id'], 'integer'],
            [['custom_code'], 'string'],
            [['name', 'alias', 'type', 'h1', 'title', 'meta_description', 'meta_keywords', 'template'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'name' => 'Название',
            'alias' => 'Алиас',
            'type' => 'Тип',
            'parent_id' => 'Родитель',
            'parent' => 'Родитель',
            'relation_id' => 'Связь с объектом',
            'h1' => 'h1',
            'title' => 'Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'template' => 'Шаблон',
            'custom_code' => 'Произвольный код',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDataSource()
    {
        return $this->hasOne(static::$availableTypes[$this->type]['class'], ['id' => 'relation_id'])->andWhere(['is_active' => 1])->andWhere(['is', 'deleted', null]);
    }

    /**
     * @return mixed
     */
    public function getModelInstance() {
        return new static::$availableTypes[$this->type]['class'];
    }

    /**
     * @return bool
     */
    public function validateType() {
        return isset(static::$availableTypes[$this->type]['class']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Page::className(), ['id' => 'parent_id'])
            ->from(Page::tableName() . ' parent')->andWhere(['is_active' => 1])->andWhere(['is', 'deleted', null]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Page::className(), ['parent_id' => 'id'])->andWhere(['is_active' => 1])->andWhere(['is', 'deleted', null])->orderBy('position ASC');
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

    /**
     * @return string
     */
    public function getTemplatePath() {
        return $this->template ? "/custom-templates/{$this->template}" : "/pages/{$this->type}";
    }

    public static function avaliableTypes()
    {
        $types = [];
        foreach(self::$availableTypes as $typeName => $typeValue) {
            $types[$typeName] = $typeValue['title'];
        }
        return $types;
    }

    public static function customTemplates()
    {
        $templates = [];
        if($files = scandir(Yii::getAlias('@frontend').'/views/custom-templates')) {
            foreach($files as $file) {
                if($file != '.' && $file != '..') {
                    $templateName = substr($file, 0, -4);
                    $templates[$templateName] = $templateName;
                }
            }
        }
        return $templates;
    }


}
