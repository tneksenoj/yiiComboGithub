<?php

namespace backend\controllers;

use Yii;
use backend\models\OcShare;
use backend\models\OcShareSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\web\ForbiddenHttpException;

/**
 * OcShareController implements the CRUD actions for OcShare model.
 */
class OcShareController extends Controller
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
                         'actions' => ['logout', 'index', 'create', 'view', 'update', 'delete', 'setperms'],
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
     * Lists all OcShare models.
     * @return mixed
     */
    public function actionIndex()
    {
      if (Yii::$app->user->can('read'))
      {
          $searchModel = new OcShareSearch();
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
     * Displays a single OcShare model.
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
     * Creates a new OcShare model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      if (Yii::$app->user->can('create'))
      {
          $model = new OcShare();

          if ($model->load(Yii::$app->request->post()) && $model->save()) {
              return $this->redirect(['view', 'id' => $model->id]);
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
     * Updates an existing OcShare model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSetperms($id, $returnPage)
    {
      if (Yii::$app->user->can('approve'))
      {
          $model = $this->findModel($id);
          if ($model->load(Yii::$app->request->post())) {

            if(!empty($model->permlist)) {
              $model->permissions = array_sum($model->permlist);
            } else {
              Yii::$app->getSession()->setFlash('error', 'User must be assigned at least read ability.'); //Prevents the creation of share with no permissions
              return $this->render('create', ['model' => $model]);
            }
          }else {
              return $this->render('update', [
                  'model' => $model,
              ]);
          }
          if ($model->save()) {
              if( $returnPage == '/requests/index' ) {
                return $this->redirect([$returnPage]);
              }
          } else {
              return $this->render('update', [
                  'model' => $model,
              ]);
          }
      }else {
           throw new ForbiddenHttpException('You do not have permission to access this page!');
         }
    }

    /* 
    * Updates project permissions
    */
    public function actionUpdate($id)
    {
      if (Yii::$app->user->can('update'))
      {
          $model = $this->findModel($id);
          if ($model->load(Yii::$app->request->post())) {
            if(!empty($model->permlist)) { //If Permlist is not empty, save
              $model->permissions = array_sum($model->permlist);
            } else {
              throw new UserException("Must have at least read ablity!");
            }
          }else {
              return $this->render('update', [
                  'model' => $model,
              ]);
          }
          if ($model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Successfully updated permissions');
                return $this->redirect([ 'index', 'id' => $model->id]);
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
     * Deletes an existing OcShare model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
      if (Yii::$app->user->can('delete'))
      {
          $this->findModel($id)->delete();

          return $this->redirect(['index']);
      }else {
           throw new ForbiddenHttpException('You do not have permission to access this page!');
         }
    }

    /**
     * Finds the OcShare model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OcShare the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OcShare::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
