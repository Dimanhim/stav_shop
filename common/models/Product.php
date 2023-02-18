<?php

namespace common\models;

use backend\components\Helpers;
use Yii;
use yii\helpers\Inflector;

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

    public $tags;
    public $product_attributes;
    public $product_attribute_types;

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
     * {@inheritdoc}
     */
    public function rules()
    {
        return parent::rules() + [
            [['name', 'alias'], 'required'],
            [['catalogue_id', 'type', 'qty', 'seller_id', 'cost_full', 'cost_old', 'cost_discount', 'discount', 'delivery_price'], 'integer'],
            [['description', 'short_description', 'note', 'attributes'], 'string'],
            [['name', 'alias', 'meta_description', 'meta_keywords'], 'string', 'max' => 255],
            [['delivery_time', 'tags', 'product_attributes', 'product_attribute_types'], 'safe'],
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
            'alias' => 'Алиас',
            'description' => 'Описание',
            'short_description' => 'Короткое описание',
            'note' => 'Примечание',
            'qty' => 'Наличие, шт.',
            'seller_id' => 'Продавец',
            'cost_full' => 'Цена',
            'cost_old' => 'Старая цена',
            'cost_discount' => 'Цена со скидкой',
            'discount' => 'Скидка в %',
            'delivery_price' => 'Стоимость доставки',
            'delivery_time' => 'Время доставки (ч.)',
            'attributes' => 'Атрибуты',     // Связь со справочником
            'tags' => 'Тэги',
            'product_attributes' => 'Атрибуты',
            'product_attribute_types' => 'Типы атрибутоа',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if(!$this->type) {
            $this->type = self::TYPE_PRODUCT;
        }
        /*if(!$this->alias) {
            $this->alias = Inflector::slug($this->name);
        }*/
        if($this->delivery_time) {
            $this->delivery_time = Helpers::getSecondsInTime($this->delivery_time);
        }
        if($this->tags) {
            ProductTag::deleteAll(['product_id' => $this->id]);
            foreach($this->tags as $tagId) {
                $model = new ProductTag();
                $model->product_id = $this->id;
                $model->tag_id = $tagId;
                $model->save();
            }
        }
        if($this->product_attributes) {
            ProductAttributes::deleteAll(['product_id' => $this->id]);
            foreach($this->product_attributes as $product_attribute) {
                $model = new ProductAttributes();
                $model->product_id = $this->id;
                $model->attribute_id = $product_attribute;
                $model->save();
            }
        }

        if($this->product_attribute_types) {
            ProductAttributeType::deleteAll(['product_id' => $this->id]);
            foreach($this->product_attribute_types as $product_attribute_type) {
                $model = new ProductAttributeType();
                $model->product_id = $this->id;
                $model->attribute_type_id = $product_attribute_type;
                $model->save();
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     *
     */
    public function afterFind()
    {
        if($this->delivery_time) {
            $this->delivery_time = Helpers::getTimeAsString($this->delivery_time);
        }
        $this->setProductTags();
        $this->setProductAttributes();
        $this->setProductAttributeTypes();
        return parent::afterFind();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogue()
    {
        return $this->hasOne(Catalogue::className(), ['id' => 'catalogue_id'])->andWhere(['is_active' => 1])->andWhere(['is', 'deleted', null]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeller()
    {
        return $this->hasOne(Seller::className(), ['id' => 'seller_id'])->andWhere(['is_active' => 1])->andWhere(['is', 'deleted', null]);
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [
            self::TYPE_PRODUCT => 'Продукт',
            self::TYPE_SERVICE => 'Услуга',
        ];
    }

    /**
     * Получает связи с тегами
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductTags()
    {
        return $this->hasMany(ProductTag::className(), ['product_id' => 'id'])->andWhere(['is_active' => 1])->andWhere(['is', 'deleted', null])->orderBy(['position' => SORT_ASC]);
    }

    /**
     * Получает связи с атрибутами товара
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttributes()
    {
        return $this->hasMany(ProductAttributes::className(), ['product_id' => 'id'])->andWhere(['is_active' => 1])->andWhere(['is', 'deleted', null])->orderBy(['position' => SORT_ASC]);
    }

    /**
     * Получает связи с типами атрибутов товара
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttributeTypes()
    {
        return $this->hasMany(ProductAttributeType::className(), ['product_id' => 'id'])->andWhere(['is_active' => 1])->andWhere(['is', 'deleted', null])->orderBy(['position' => SORT_ASC]);
    }

    /**
     * Получает модели тегов товара
     *
     * @return array|bool
     */
    public function getProductTagsModels()
    {
        if($productTags = $this->productTags) {
            $models = [];
            foreach($productTags as $productTag) {
                if($tag = $productTag->tag) {
                    $models[] = $tag;
                }
            }
            return $models;
        }
        return false;
    }

    /**
     * Получает модели атрибутов товара
     *
     * @return array|bool
     */
    public function getProductAttributesModels()
    {
        if($productAttributes = $this->productAttributes) {
            $models = [];
            foreach($productAttributes as $productAttribute) {
                if($attribute = $productAttribute->productAttribute) {
                    $models[] = $attribute;
                }
            }
            return $models;
        }
        return false;
    }

    /**
     * Получает модели типов атрибутов товара
     *
     * @return array|bool
     */
    public function getProductAttributeTypesModels()
    {
        if($productAttributeTypes = $this->productAttributeTypes) {
            $models = [];
            foreach($productAttributeTypes as $productAttributeType) {
                if($attributeType = $productAttributeType->productAttributeType) {
                    $models[] = $attributeType;
                }
            }
            return $models;
        }
        return false;
    }

    /**
     * Устанавливает массив id имеющихся тегов товара
     */
    public function setProductTags()
    {
        $result = [];
        if($productTags = $this->productTagsModels) {
            foreach($productTags as $productTag) {
                $result[] = $productTag->id;
            }
        }
        $this->tags = $result;
    }

    /**
     * Устанавливает массив id атрибутов товара
     */
    public function setProductAttributes()
    {
        $result = [];
        if($productAttributes = $this->productAttributesModels) {
            foreach($productAttributes as $productAttribute) {
                $result[] = $productAttribute->id;
            }
        }
        $this->product_attributes = $result;
    }

    /**
     *  Устанавливает массив id типов атрибутов товара
     */
    public function setProductAttributeTypes()
    {
        $result = [];
        if($productAttributeTypes = $this->productAttributeTypes) {
            foreach($productAttributeTypes as $productAttributeType) {
                $result[] = $productAttributeType->attribute_type_id;
            }
        }
        $this->product_attribute_types = $result;
    }

    /**
     * HTML
     * Возвращает представление списка тегов
     *
     * @return bool
     */
    public function getTagsChunk()
    {
        if($productTags = $this->productTagsModels) {
            return $this->getListChunk($productTags);
        }
    }

    /**
     * @return string
     */
    public function getFullUri() {
        return $this->catalogue ? $this->catalogue->fullUri.'/'.$this->alias : '';
        //return $this->alias;
        $fullPath = [];
        $page = $this;

        if ($page->alias == '/') {
            return '/';
        }

        do {
            $fullPath[] = $page->alias;
            if ($page->catalogue_id) {
                $page = $page->catalogue;
            } else {
                $page = null;
            }
        } while ($page);

        return '/'.implode('/', array_reverse($fullPath));
    }

// ---------------------------------------- BEGIN Работа с чекбоксами типов атрибутов и атрибутов
    /**
     * Метод рендерит всю плашку выбора типов атрибутов
     * и атрибутов к ним
     *
     * @return string
     */
    public function getAttributesTypesListHtml()
    {
        return Yii::$app->controller->renderPartial('//chunks/attributes/_container',[
            'model' => $this,
        ]);
    }

    /**
     * Добавляет дерево типов атрибутов
     * @return string
     */
    public function getCheckboxesTree()
    {
        $tree = AttributeType::buildTree();
        $str = '<ul class="attribute-type-list attribute-type-list-o list-block">';
        $str .= $this->getCheckboxesItems($tree);
        $str .= '<ul>';
        return $str;
    }

    /**
     * Рекурсивный метод рендеринга дерева чекбоксов типов атрибутов
     * @param $tree
     * @return string
     */
    public function getCheckboxesItems($tree)
    {
        $str = '';
        if(!empty($tree)) {
            $str .= '<ul class="attribute-type-sublist">';
            $str .= Yii::$app->controller->renderPartial('//chunks/attributes/_checkboxes_types_tree', [
                'tree' => $tree,
                'model' => $this,
            ]);
            $str .= '</ul>';
        }
        return $str;
    }

    /**
     * HTML
     * Получает чекбоксы атрибутов товара,
     * на основе выбранного типа, либо самого первого типа
     *
     * @return string
     */
    public function getCheckboxesAttributes()
    {
        return '';
    }
// ---------------------------------------- END Работа с чекбоксами типов атрибутов и атрибутов
}
