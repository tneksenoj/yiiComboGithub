<?php

namespace backend\controllers;

use Yii;
use backend\models\Credentials;
use backend\models\CredentialsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\helpers\BaseUrl;
use yii\web\ForbiddenHttpException;

/**
 * CredentialsController implements the CRUD actions for Credentials model.
 */
class CredentialsController extends Controller
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
     * Lists all Credentials models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CredentialsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Credentials model.
     * @param integer $UID
     * @param integer $PID
     * @return mixed
     */
    public function actionView($UID, $PID)
    {
        return $this->render('view', [
            'model' => $this->findModel($UID, $PID),
        ]);
    }

    /**
     * Creates a new Credentials model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Credentials();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'UID' => $model->UID, 'PID' => $model->PID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Credentials model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $UID
     * @param integer $PID
     * @return mixed
     */
    public function actionUpdate($UID, $PID)
    {
        $model = $this->findModel($UID, $PID);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'UID' => $model->UID, 'PID' => $model->PID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Credentials model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $UID
     * @param integer $PID
     * @return mixed
     */
    public function actionDelete($UID, $PID)
    {
        $this->findModel($UID, $PID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Credentials model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $UID
     * @param integer $PID
     * @return Credentials the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($UID, $PID)
    {
        if (($model = Credentials::findOne(['UID' => $UID, 'PID' => $PID])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
