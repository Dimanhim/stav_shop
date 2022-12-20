<?php

namespace common\models;

use himiklab\sortablegrid\SortableGridBehavior;
use himiklab\thumbnail\EasyThumbnailImage;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\UploadedFile;

class BaseModel extends ActiveRecord
{
    public $image_field;
    public $image_fields = ['image_field' => 'image_id'];
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
     * @return array
     */
    public function rules()
    {
        return [
            [['image_field', 'image_preview_field', 'unique_id', 'is_active', 'deleted', 'position', 'created_at', 'updated_at'], 'safe'],
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
        $this->handleImages();
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * @return mixed
     */
    public static function findModels()
    {
        return self::className()::find()->where(['is_active' => 1])->andWhere(['is', 'deleted', null])->orderBy(['position' => 'SORT ASC']);
    }

    /**
     * @return array
     */
    public static function getList()
    {
        return ArrayHelper::map(self::findModels()->asArray()->all(), 'id', 'name');
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

        foreach ($this->image_fields as $image_field => $image_fieldName) {
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
        }
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
}
