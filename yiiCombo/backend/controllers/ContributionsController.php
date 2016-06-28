<?php

namespace backend\controllers;

use Yii;
use backend\models\Contributions;
use backend\models\ContributionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\helpers\BaseUrl;
use yii\web\ForbiddenHttpException;

/**
 * ContributionsController implements the CRUD actions for Contributions model.
 */
class ContributionsController extends Controller
{
    /**
     * @inheritdoc
     */
     public function behaviors()
     {
         return [
             'access' => [
                 'class' => AccessControl::className(),
                 'rules' => [
                     [
                         'actions' => ['login', 'error'],
                         'allow' => true,
                     ],
                     [
                         'actions' => ['logout', 'index', 'create', 'view', 'update', 'delete'],
                         'allow' => true,
                         'roles' => ['@'],
                     ],
                 ],
             ],
             'verbs' => [
                 'class' => VerbFilter::className(),
                 'actions' => [
                     'delete' => ['POST'],
                 ],
             ],
         ];
     }

    /**
     * Lists all Contributions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContributionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contributions model.
     * @param integer $UID
     * @param integer $DID
     * @return mixed
     */
    public function actionView($UID, $DID)
    {
        return $this->render('view', [
            'model' => $this->findModel($UID, $DID),
        ]);
    }

    /**
     * Creates a new Contributions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contributions();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'UID' => $model->UID, 'DID' => $model->DID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Contributions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $UID
     * @param integer $DID
     * @return mixed
     */
    public function actionUpdate($UID, $DID)
    {
        $model = $this->findModel($UID, $DID);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'UID' => $model->UID, 'DID' => $model->DID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Contributions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $UID
     * @param integer $DID
     * @return mixed
     */
    public function actionDelete($UID, $DID)
    {
        $this->findModel($UID, $DID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Contributions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $UID
     * @param integer $DID
     * @return Contributions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($UID, $DID)
    {
        if (($model = Contributions::findOne(['UID' => $UID, 'DID' => $DID])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
