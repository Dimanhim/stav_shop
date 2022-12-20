<?php

namespace backend\controllers;

use Yii;
use common\models\ClinicType;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use himiklab\sortablegrid\SortableGridAction;

/**
 1. переписываем behavours
 2. удаляем actionDelete
 3. удаляем findModel
*/
class BaseController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        //'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actions()
    {
        return [
            'sort' => [
                'class' => SortableGridAction::className(),
                'modelName' => $this->behaviors()['className'],
            ],
        ];
    }

    /**
     * Deletes an existing ClinicType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->deleted = 1;
        if($model->save()) {
            Yii::$app->session->setFlash('success', 'Запись удалена успешно');
        }
        return $this->redirect(Yii::$app->request->referrer);
        //$this->findModel($id)->delete();
        //return $this->redirect(['index']);
    }

    /**
     * Finds the ClinicType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ClinicType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        $behavours = $this->behaviors();
        if(array_key_exists('className', $this->behaviors())) {
            if (($model = $behavours['className']::findOne(['id' => $id])) !== null) {
                return $model;
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
