<?php

use himiklab\thumbnail\EasyThumbnailImage;
use yii\helpers\Html;

?>

<?php if ($model && ($images = $model->images)): ?>
    <div class="container-fluid">
        <div class="image-preview-container">
            <div class="row image-preview-container-o">
                <?php foreach($images as $image) : ?>
                    <div class="col-3 image-preview image-preview-o" data-id="<?= $image->id ?>">
                        <div class="image-preview-content">
                            <a href="<?= EasyThumbnailImage::thumbnailFileUrl(Yii::getAlias('@upload').$image->path, 1000, 1000, EasyThumbnailImage::THUMBNAIL_OUTBOUND) ?>" data-fancybox="gallery">
                                <?= EasyThumbnailImage::thumbnailImg(Yii::getAlias('@upload').$image->path, 100, 100, EasyThumbnailImage::THUMBNAIL_OUTBOUND) ?>
                            </a>

                            <p>
                                <?= Html::a('Удалить', ['images/delete', 'id' => $image->id], ['class' => 'btn btn-sm btn-danger delete-image delete-image-o', 'data-confirm' => 'Удалить изображение?']) ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif ?>
