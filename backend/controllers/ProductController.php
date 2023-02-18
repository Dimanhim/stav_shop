<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use backend\models\ProductSearch;
use common\models\ProductAttributeType;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends BaseController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'className' => Product::className(),
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();

        $model->type = Product::TYPE_DEFAULT;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionSelectProductType()
    {
        // product_id: product_id, attribute_type_id: attribute_type_id, checked: checked
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = [
            'result' => false,
            'message' => null,
            'html' => null,
        ];

        $product_id = Yii::$app->request->post('product_id');
        $attribute_type_id = Yii::$app->request->post('attribute_type_id');
        $checked = Yii::$app->request->post('checked');

        if(!$productAttributeType = ProductAttributeType::findOne(['product_id' => $product_id, 'attribute_type_id' => $attribute_type_id])) {
            $productAttributeType = new ProductAttributeType();
            $productAttributeType->product_id = $product_id;
            $productAttributeType->attribute_type_id = $attribute_type_id;
            $productAttributeType->save();
        }
        if($checked) {
            $productAttributeType->addModel();
        }
        else {
            $productAttributeType->deleteModel();
        }
        $model = Product::findOne($product_id);
        $response['result'] = true;
        $response['message'] = 'Тип успешно изменен';
        $response['html'] = $model->getCheckboxesTree();
        return $response;
    }

}
