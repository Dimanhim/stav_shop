<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];

    /**
     *
     */
    public function init()
    {
        $this->css = static::getCss();
        $this->js = static::getJs();
    }

    /**
     * @return array
     */
    public static function getCss()
    {
        return [
            'css/jquery-ui.min.css',
            'css/chosen.css',
            'css/jquery.fancybox.min.css',
            'css/site.css?v='.mt_rand(1000,10000),
        ];
    }

    /**
     * @return array
     */
    public static function getJs()
    {
        return [
            'js/jquery-ui.min.js',
            'js/chosen.jquery.min.js',
            'js/jquery.fancybox.min.js',
            'js/slugify.js',
            'js/inputmask.js',
            'js/jquery.inputmask.js',
            'js/common.js?v='.mt_rand(1000,10000),
        ];
    }
}
