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
            'js/chosen.jquery.min.js',
            'js/jquery.fancybox.min.js',
            'js/common.js?v='.mt_rand(1000,10000),
        ];
    }
}
