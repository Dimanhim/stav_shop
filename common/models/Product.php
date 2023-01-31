<?php

namespace common\models;

use backend\components\Helpers;
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

    public $tags;

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
            [['name'], 'required'],
            [['catalogue_id', 'type', 'qty', 'client_id', 'cost_full', 'cost_old', 'cost_discount', 'discount', 'delivery_price'], 'integer'],
            [['description', 'short_description', 'note', 'attributes'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['delivery_time', 'tags'], 'safe'],
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
            'note' => 'Примечание',
            'qty' => 'Наличие, шт.',
            'client_id' => 'Клиент',
            'cost_full' => 'Цена',
            'cost_old' => 'Старая цена',
            'cost_discount' => 'Цена со скидкой',
            'discount' => 'Скидка в %',
            'delivery_price' => 'Стоимость доставки',
            'delivery_time' => 'Время доставки (ч.)',
            'attributes' => 'Атрибуты',     // Связь со справочником
            'tags' => 'Тэги',
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
        return parent::afterFind();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogue()
    {
        return $this->hasOne(Catalogue::className(), ['id' => 'catalogue_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
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
     * @return \yii\db\ActiveQuery
     */
    public function getProductTags()
    {
        return $this->hasMany(ProductTag::className(), ['product_id' => 'id']);
    }

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
     *
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
     * @return bool
     */
    public function getTagsChunk()
    {
        if($productTags = $this->productTagsModels) {
            return $this->getListChunk($productTags);
        }
    }
}
