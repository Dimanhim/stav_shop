<?php

namespace backend\controllers;

use common\models\Page;
use backend\models\PageSearch;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends BaseController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'className' => Page::className(),
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
     * Lists all Page models.
     *
     * @return string
     */
    public function actionIndex($type = null)
    {
        $searchModel = new PageSearch();
        $searchModel->type = $type;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $type,
        ]);
    }

    /**
     * Displays a single Page model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $page = $this->findModel($id);
        $model = $page->dataSource;
        return $this->render('view', [
            'page' => $page,
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($type = 'content-pages')
    {
        $page = new Page();
        $page->type = $type;
        $page->is_active = true;

        if (!$page->validateType()) {
            throw new BadRequestHttpException('Запрошенная страница не существует.');
        }

        $model = $page->getModelInstance();

        if ($model->load(Yii::$app->request->post()) && $page->load(Yii::$app->request->post())) {
            $model->save();
            $page->relation_id = $model->id;
            $page->save();
            return $this->redirect(['update', 'id' => $page->id]);
        }

        return $this->render('create', [
            'page' => $page,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $page = $this->findModel($id);
        $model = $page->dataSource;

        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post()) && $page->load(Yii::$app->request->post())) {
            $model->update(false);
            $page->save();
            return $this->redirect(['update', 'id' => $page->id]);
        }

        return $this->render('update', [
            'page' => $page,
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $page = $this->findModel($id);
        $type = $page->type;
        $model = $page->dataSource;

        $model->is_active = 0;
        $page->is_active = 0;
        if($model->save() && $page->save()) {
            return $this->redirect(['index', 'type' => $type]);
        }
    }
}
