<?php

namespace backend\controllers;

use Yii;
use yii\web\Application;
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
use common\config\yiicfg;
use marnold22\yii2\curl;

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
      //Init curl
      $curl = new curl\Curl();

      if($curl->mkcol(yiicfg::WebDav . $projectName))
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
      //Init curl
      $curl = new curl\Curl();

      if($curl->delete(yiicfg::WebDav . $projectName))
        {
          return true;
        }
      return false;
    }

/*

    public function createProjectGroupOnOwncloud($groupName)
    {
      $client = new WebClient([
          'responseConfig' => [
              'format' => WebClient::FORMAT_JSON
          ],
      ]);

      $response = $client->createRequest()
        ->setMethod('post')
        ->setUrl(yiicfg::OCS. 'groups')
        ->setData(['groupid' => $groupName])
        ->setOptions(['timeout' => 5,])
        ->send();

        $p = xml_parser_create();
        xml_parse_into_struct($p, $response->content, $vals, $index);
        xml_parser_free($p);

        if ( $vals[2]['value'] == "ok") {
          return true;
        } else {
          return false;
        }
    }


    public function deleteProjectGroupOnOwncloud($groupName)
    {
      $client = new WebClient([
          'responseConfig' => [
              'format' => WebClient::FORMAT_JSON
          ],
      ]);
      $response = $client->createRequest()
        ->setMethod('delete')
        ->setUrl(yiicfg::OCS . 'groups/' . $groupName)
        ->setOptions(['timeout' => 5,])
        ->send();

        $p = xml_parser_create();
        xml_parse_into_struct($p, $response->content, $vals, $index);
        xml_parser_free($p);

        if ( $vals[2]['value'] == "ok") {
          return true;
        } else {
          return false;
        }
    }
    */

    public function shareFolderOnOwncloud($groupName) {
      $client = new WebClient(
      [
          'responseConfig' => [
              'format' => WebClient::FORMAT_JSON
          ],
      ]
    );
    //curl -X POST /shares -d path="/Projects/Land" -d shareType=1 -d shareWith="Land"

      $response = $client->createRequest()
        ->setMethod('post')
        ->setUrl(yiicfg::OCS_SHARE . 'shares')
        ->setData(['path' => '/Projects/'.$groupName, 'shareType' => 1, 'shareWith' => $groupName])
        ->setOptions(['timeout' => 5,])
        ->send();

        $p = xml_parser_create();
        xml_parse_into_struct($p, $response->content, $vals, $index);
        xml_parser_free($p);

        if ( $vals[$index['STATUS'][0]]['value'] == "ok") {
          return true;
        } else {
          return false;
        }
    }




    /**
     * Creates a new Projects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed = new WebClient()
     */
    public function actionCreate()
    {
      //Init curl
      $curl = new curl\Curl();

      if (Yii::$app->user->can('create')) {
        $model = new Projects();
        if ($model->load(Yii::$app->request->post())) {
          $exists = $curl->has(yiicfg::WebDav . $model->Name);
          if ($exists){
            throw new UserException('Sorry that name is already in use on the project server.');
          }
          if ( $model->validate() ) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if($model->file) {
              $model->logo = 'uploads/' . $model->file->baseName . '.' . $model->file->extension;
            }
            if (!$model->save()) {
              throw new UserException("× Check to ensure no spaces exist in your logo filename. \nSorry, an error occured in your action \"create\" of the project controller. Please contact an administrator.");
            } //Edited to include message about spaces in logo filename.

            if ($model->file && !$model->file->saveAs($model->logo)) {
              $error = $model->getErrors();
              $model->delete();
              throw new UserException("Error saving file " . json_encode($error));
            }

            if (!$this->createProjectOnOwncloud($model->Name)) {
              $model->delete();
              throw new UserException("Error creating project.");
            }

            return $this->redirect(['view', 'id' => $model->PID, 'logo' => $model->logo]);
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

       //Init curl
       $curl = new curl\Curl();

       if (Yii::$app->user->can('update')) {
         $model = $this->findModel($id);
         $oldmodel = clone $model;

        if ($model->load(Yii::$app->request->post())) { 

           if ( $model->validate() ) {
             if (!$curl->has(yiicfg::WebDav . $oldmodel->Name)){
               throw new UserException('Sorry that project does not exist on OwnCloud.'); /* This error thrown */
             }             
             $ret = $curl->rename(yiicfg::WebDav . $oldmodel->Name, yiicfg::OC_files . $model->Name, yiicfg::HOST); /* Returns false */
             //Yii::error("\r\n" . '+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++' . "\r\n" . "\r\n" . json_encode($ret));
             $model->file = UploadedFile::getInstance($model, 'file'); 
             // Yii::error(yiicfg::WebDav . $oldmodel->Name . ' | ' . yiicfg::OC_files . $model->Name . ' | ' .yiicfg::HOST);
             /* This check is not implemented because if a user hits update without changing anything, Owncloud will return "forbidden" 
             because we are trying to rename a project to itself.
             if(!$ret){
               throw new UserException('Error in Curl during rename of owncloud folder- ProjectsController.php Function actionUpdate');
             }*/
             
             if($model->file) {
               $model->logo = 'uploads/' . $model->file->baseName . '.' . $model->file->extension;
             }
             if (!$model->save()) {
               throw new UserException('Sorry, an error occured in the function actionUpdate of ProjectsController. Please contact the administrator.');
             }
             if ($model->file && !$model->file->saveAs($model->logo)) {
               $error = $model->getErrors();
               $model->delete();
               throw new UserException("Error saving file " . json_encode($error));
             }

             return $this->redirect(['view', 'id' => $model->PID, 'logo' => $model->logo]);
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

/*
    public function actionUpdateold($id)
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
    */

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
          $model->delete();

          $status = true;
          if ( !$this->deleteProjectOnOwncloud($model->Name) ) {
            $status = false;
          };
          if ( !$status ) {
            throw new UserException("Project group likely removed from Yii but error removing from OwnCloud.");
          }
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
