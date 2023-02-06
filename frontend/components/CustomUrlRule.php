<?php

namespace frontend\components;

use common\models\Catalogue;
use common\models\Page;
use common\models\Product;
use yii\base\BaseObject;
use yii\web\UrlRuleInterface;

class CustomUrlRule extends BaseObject implements UrlRuleInterface
{
    public function createUrl($manager, $route, $params)
    {
        return false; // this rule does not apply
    }

    /**
     * @param \yii\web\UrlManager $manager
     * @param \yii\web\Request $request
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();

        $pathParts = explode('/', $pathInfo);
        $lastPart = end($pathParts);
        if (!$lastPart) {
            $lastPart = '/';
        }

        if($products = Product::find()->where(['alias' => $lastPart, 'is_active' => 1])->all()) {
            if($model = $this->modelPath($products, $pathInfo, Product::class)) {
                return $model;
            }
        }
        if($categories = Catalogue::find()->where(['alias' => $lastPart, 'is_active' => 1])->all()) {
            if($model = $this->modelPath($categories, $pathInfo, Catalogue::class)) {
                return $model;
            }
        }
        if($pages = Page::find()->where(['alias' => $lastPart, 'is_active' => 1])->all()) {
            if($model = $this->modelPath($pages, $pathInfo, Page::class)) {
                return $model;
            }
        }

        return false;
    }

    private function modelPath($models, $pathInfo, $className) {

        foreach ($models as $model) {
            if ($model and $model->getFullUri() == '/'.$pathInfo) {
                Page::$current = $model;
                switch ($className) {
                    case Product::class : {
                        return ['site/product', [
                            'product' => $model,
                        ]];
                    }
                        break;
                    case Page::class : {
                        return ['site/page', [
                            'page' => $model,
                        ]];
                    }
                        break;
                    case Catalogue::class : {
                        return ['site/catalogue', [
                            'catalogue' => $model,
                        ]];
                    }
                        break;
                }

            }
        }
    }
}
