<?php

namespace common\models;

use himiklab\sortablegrid\SortableGridBehavior;
use himiklab\thumbnail\EasyThumbnailImage;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\grid\ActionColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
1. добавить static метод modelName
2. удалить во вью $this->title
3. В классе Product поменять beforeSave
// 4. добавить static метод typeName - это для сохранения сущности картинок. По ходу не нужно
5. в класс Gallery добавить типы изображений
6. добавить static метод typeId
 * включить ajax валидацию в форме
 */
class BaseModel extends ActiveRecord
{
    public $image_field;
    //public $image_fields = ['image_field' => 'image_id'];
    public $image_fields;
    public $image_preview_field = [];

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'sort' => [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => 'position',
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function getModelName()
    {
        return self::className()::modelName();
    }

    /**
     * @return mixed
     */
    public function getTypeId()
    {
        return self::className()::typeId();
    }

    /**
     * @return mixed
     */
    /*public function getTypeName()
    {
        return self::className()::typeName();
    }*/

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['image_field', 'image_fields', 'image_preview_field', 'unique_id', 'is_active', 'deleted', 'position', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unique_id' => 'Уникальный ID',
            'image_field' => 'Изображение',
            'image_fields' => 'Изображение',
            'image_preview_field' => 'Превью изображения',
            'is_active' => 'Активность',
            'deleted' => 'Удален',
            'position' => 'Сортировка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата редактирования',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if(!$this->unique_id) $this->unique_id = uniqid();
        $this->handleImages();
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($insert) {
            Yii::$app->session->setFlash('success', 'Запись успешно добавлена');
        }
        else {
            Yii::$app->session->setFlash('success', 'Запись успешно обновлена');
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * @return bool
     */
    public function getMainImage()
    {
        if($this->gallery && $this->gallery->images) {
            return $this->gallery->images[0];
        }
        return false;
    }

    /**
     * @return mixed
     */
    public static function findModels()
    {
        return self::className()::find()->where(['is', 'deleted', null])->andWhere(['is_active' => 1])->orderBy(['position' => 'SORT ASC']);
    }

    /**
     * @return mixed
     */
    public function findSearch()
    {
        return self::className()::find()->where(['is', 'deleted', null])->orderBy(['position' => 'SORT ASC']);
    }

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function deleteModel()
    {
        file_put_contents('info-log.txt', date('d.m.Y H:i:s').' - '.print_r('delete', true)."\n", FILE_APPEND);
        $this->is_active = null;
        $this->deleted = 1;
        $this->update(false);
    }

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function addModel()
    {
        $this->is_active = 1;
        $this->deleted = null;
        $this->update(false);
    }

    /**
     * @return array
     */
    public static function getList()
    {
        return ArrayHelper::map(self::findModels()->asArray()->all(), 'id', 'name');
    }

    /**
     * @return array|ActiveRecord[]
     */
    public function getGallery()
    {
        return Gallery::find()->where(['object_type' => $this->typeId, 'object_id' => $this->id])->one();
    }

    /**
     * @param $models
     * @return bool
     */
    public function getListChunk($models)
    {
        if(!$models) return false;
        return Yii::$app->controller->renderPartial('//chunks/_list_names', [
            'models' => $models,
        ]);
    }

    /**
     * @param $models
     * @return bool
     */
    public function getListLinksChunk($models, $link)
    {
        if(!$models) return false;
        return Yii::$app->controller->renderPartial('//chunks/_list_links', [
            'models' => $models,
            'link' => $link,
        ]);
    }

    /**
     * @return string
     */
    public function getFigmaLink()
    {
        if($this->figma) {
            return Html::a('В новом окне', $this->figma, ['target' => '_blanc']);
        }
    }

    private function handleImages() {

        $prefix = Yii::$app->db->tablePrefix;
        $dirName = str_replace($prefix, '', self::className()::tableName());
        $filesDir = Yii::getAlias('@upload')."/{$dirName}/";
        if (!file_exists($filesDir)) mkdir($filesDir, 0777, true);

        if($files = UploadedFile::getInstances($this, 'image_fields')) {
            if(!$gallery = $this->gallery) {
                $gallery = new Gallery();
                $gallery->object_id = $this->id;
                $gallery->object_type = $this->typeId;
                $gallery->save();
            }
            foreach($files as $file) {
                $fileName = $this->id.'_'.uniqid();
                $filePath = "/{$dirName}/{$fileName}.{$file->extension}";

                if (!$file->saveAs(Yii::getAlias('@upload').$filePath)) {
                    continue;
                }

                $image = Image::create($filePath, $gallery->id);
            }
        }


        /*foreach ($this->image_fields as $image_field => $image_fieldName) {
            if ($file = UploadedFile::getInstance($this, $image_field)) {
                $fileName = md5(time().$image_fieldName);
                $filePath = "/{$dirName}/{$fileName}.{$file->extension}";

                if (!$file->saveAs(Yii::getAlias('@upload').$filePath)) {
                    continue;
                }

                if ($this->$image_fieldName and ($existingImage = Image::findOne($this->$image_fieldName))) {
                    $existingImage->delete();
                }

                if ($image = Image::create($filePath)) {
                    $this->$image_fieldName = $image->id;
                }
            }
        }*/
    }

    /**
     * @return string
     */
    public function getImg()
    {
        if($this->image) {
            $img = EasyThumbnailImage::thumbnailImg(Yii::getAlias('@upload').$this->image->path, 100, 100, EasyThumbnailImage::THUMBNAIL_OUTBOUND);
            return Html::a($img, '/upload/'.$this->image->path, ['target' => '_blanc']);
        }
    }

    public function getMainImageHtml()
    {
        if($this->mainImage) return Html::a(
            EasyThumbnailImage::thumbnailImg(Yii::getAlias('@upload').$this->mainImage->path, 100, 100, EasyThumbnailImage::THUMBNAIL_OUTBOUND),
            EasyThumbnailImage::thumbnailFileUrl(Yii::getAlias('@upload').$this->mainImage->path, 1000, 1000, EasyThumbnailImage::THUMBNAIL_OUTBOUND),
            ['data-fancybox' => 'gallery']
        );
    }
    public function getImagesHtml()
    {
        if($this->gallery) return $this->gallery->getPreviewListHTML();
    }
    public function getAvatar()
    {
        if($this->mainImage) {
            return '/upload'.$this->mainImage->path;
        }
        return '../img/no-img.png';
    }

    public function getActive()
    {
        return $this->is_active ? 'Да' : 'Нет';
    }
    public function getCreatedAt()
    {
        return date('d.m.Y H:i', $this->created_at);
    }
    public function getUpdatedAt()
    {
        return date('d.m.Y H:i', $this->updated_at);
    }

    public function getImagesField($form)
    {
        return Yii::$app->controller->renderPartial('//chunks/_images_form_field', [
            'form' => $form,
            'model' => $this,
        ]);
    }

    public function getFormCard($attributes = [], $cardName = '')
    {
        return Yii::$app->controller->renderPartial('//chunks/_form_card', [
            'attributes' => $attributes,
            'cardName' => $cardName,
        ]);
    }
}
