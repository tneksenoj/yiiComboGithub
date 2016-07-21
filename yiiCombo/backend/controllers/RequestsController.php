<?php

namespace backend\controllers;

use Yii;
use backend\models\Requests;
use backend\models\RequestsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UrlRule;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use backend\models\User;
use backend\models\OcUsers;
use yii\web\ForbiddenHttpException;
/**
 * RequestsController implements the CRUD actions for Requests model.
 */
class RequestsController extends Controller
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
                      'actions' => ['index', 'create', 'view', 'update', 'delete', 'addtooc'],
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
     * Lists all Requests models.
     * @return mixed
     */
    public function actionIndex()
    {
      if (Yii::$app->user->can('read'))
      {
          $searchModel = new RequestsSearch();
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

          return $this->render('index', [
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,
          ]);
      }else {
            throw new ForbiddenHttpException('You do not have permission to access this page!');
          }
    }

    /**
     * Displays a single Requests model.
     * @param string $username
     * @param string $projectname
     * @return mixed
     */
    public function actionView($username, $projectname)
    {
      if (Yii::$app->user->can('read'))
      {
          return $this->render('view', [
              'model' => $this->findModel($username, $projectname),
          ]);
      }else {
            throw new ForbiddenHttpException('You do not have permission to access this page!');
          }
    }


    public function actionAddtooc($username, $projectname)
    {
      if (Yii::$app->user->can('approve'))
      {
          if(!Requests::addUserToGroup($username, $projectname)) {
            throw new UserException('Sorry there was an error creating user on OwnCloud.');
          }else {
              $this->findModel($username, $projectname)->delete();
              return $this->redirect(['index']);
          }
      } else {
            throw new ForbiddenHttpException('You do not have permission to access this page!');
          }
    }

    /**
     * Creates a new Requests model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      if (Yii::$app->user->can('create'))
      {
          $model = new Requests();

          if ($model->load(Yii::$app->request->post()) && $model->save()) {
              return $this->redirect(['view', 'username' => $model->username, 'projectname' => $model->projectname]);
          } else {
              return $this->render('create', [
                  'model' => $model,
              ]);
          }
      }else {
            throw new ForbiddenHttpException('You do not have permission to access this page!');
          }
    }

    /**
     * Updates an existing Requests model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $username
     * @param string $projectname
     * @return mixed
     */
    public function actionUpdate($username, $projectname)
    {
      if (Yii::$app->user->can('update'))
      {
          $model = $this->findModel($username, $projectname);

          if ($model->load(Yii::$app->request->post()) && $model->save()) {
              return $this->redirect(['view', 'username' => $model->username, 'projectname' => $model->projectname]);
          } else {
              return $this->render('update', [
                  'model' => $model,
              ]);
          }
      }else {
            throw new ForbiddenHttpException('You do not have permission to access this page!');
          }
    }

    /**
     * Deletes an existing Requests model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $username
     * @param string $projectname
     * @return mixed
     */
    public function actionDelete($username, $projectname)
    {
      if (Yii::$app->user->can('delete'))
      {
          $this->findModel($username, $projectname)->delete();
          return $this->redirect(['index']);
      }else {
            throw new ForbiddenHttpException('You do not have permission to access this page!');
          }
    }

    /**
     * Finds the Requests model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $username
     * @param string $projectname
     * @return Requests the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($username, $projectname)
    {
        if (($model = Requests::findOne(['username' => $username, 'projectname' => $projectname])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
