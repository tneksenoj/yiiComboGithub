<?php

namespace backend\controllers;

use Yii;
use backend\models\Projects;
use backend\models\ProjectsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\base\UserException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\helpers\BaseUrl;
use yii\web\ForbiddenHttpException;
use yii\httpclient\Client as WebClient;
use creocoder\flysystem;
use creocoder\flysystem\fs;


/**
 * ProjectsController implements the CRUD actions for Projects model.
 */
class ProjectsController extends Controller
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
     * Lists all Projects models.
     * @return mixed
     */
    public function actionIndex()
    {
      if (Yii::$app->user->can('read'))
      {
          $searchModel = new ProjectsSearch();
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
     * Displays a single Projects model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
      if (Yii::$app->user->can('read'))
      {
          return $this->render('view', [
              'model' => $this->findModel($id),
          ]);
      }else {
            throw new ForbiddenHttpException('You do not have permission to access this page!');
          }
    }

    /**
     * Creates a new Projects on owncloud.
     * @return bool
     */
    public function createProjectOnOwncloud($projectName)
    {
      if(Yii::$app->webdavFs->createDir(Yii::$app->params['OC_files'] . $projectName))
        {
          return true;
        }
      return false;
    }


    /**
     * Creates a new Projects on owncloud.
     * @return bool
     */
    public function deleteProjectOnOwncloud($projectName)
    {
      if(Yii::$app->webdavFs->deleteDir(Yii::$app->params['OC_files'] . $projectName))
        {
          return true;
        }
      return false;
    }

    /**
     * Creates a new Projects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     *&& $model->validate()
     */
    public function actionCreate()
    {
      if (Yii::$app->user->can('create')) {
        $model = new Projects();
        if ($model->load(Yii::$app->request->post())) {
          if (Yii::$app->webdavFs->has(Yii::$app->params['OC_files'] . $model->Name)){
            throw new UserException('Sorry that name is already in use on the project server.');
          }
          $model->file = UploadedFile::getInstance($model, 'file');
          if ($model->validate()) {
            $model->logo = 'uploads/' . $model->file->baseName . '.' . $model->file->extension;
            if (!$model->save()) {
              throw new UserException('Sorry an error occured in your action create of the project controller. Please contact the administrator.');
            }
            $model->file->saveAs($model->logo);

            if ($this->createProjectOnOwncloud($model->Name)) {
              return $this->redirect(['view', 'id' => $model->PID, 'logo' => $model->logo]);
            } else {
              $this->findModel($model->PID)->delete();
              return $this->render('create', [
                'model' => $model, ]);
            }
          } else {
            $error = $model->getErrors();
            throw new UserException("Error in model validation " . json_encode($error));
          }
        } else {
          return $this->render('create', [
            'model' => $model,
            ]);
        }
      } else {
        throw new ForbiddenHttpException('You do not have permission to access this page!');
      }
    }

    /**
     * Updates an existing Projects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
      if (Yii::$app->user->can('update'))
      {
          $model = $this->findModel($id);

          if ($model->load(Yii::$app->request->post()) && $model->save()) {
              return $this->redirect(['view', 'id' => $model->PID]);
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
     * Deletes an existing Projects model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
      if (Yii::$app->user->can('delete'))
      {
          $model = $this->findModel($id);
          error_log("This is the model name... " . $model->Name);
          $model->delete();
          $this->deleteProjectOnOwncloud($model->Name);

          return $this->redirect(['index']);
      }else {
            throw new ForbiddenHttpException('You do not have permission to access this page!');
          }
    }

    /**
     * Finds the Projects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Projects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Projects::findOne($id)) !== null) {
            return $model;
        }else {
              throw new ForbiddenHttpException('You do not have permission to access this page!');
            }
    }
}
