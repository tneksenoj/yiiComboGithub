<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\UploadForm;
use frontend\models\CreateProject;
use backend\models\Projects;
use backend\models\ProjectsSearch;
use backend\models\ProjectsController;
use backend\models\SiteData;;
use backend\models\SiteDataSearch;
use backend\models\SiteDataController;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\db\Connection;
use yii\data\ActiveDataProvider;
use backend\models\Requests;
use yii\base\UserException;
use yii\web\ForbiddenHttpException;
use yii\helpers\Html;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'projects', 'files'],
                'rules' => [
                    [
                        'actions' => ['projects', 'files'],
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'projects', 'files'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays a single Projects model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
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
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
    *
    *
    * @return mixed
    */
    /*public function actionCreateProject()
    {
        $model = new CreateProject();

        return $this->render('createProject', ['model' => $model]);
    }
    */

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    /**
    * Displays Projects page
    * Displays all projects too
    * @return mixed
    */
    public function actionProjectsold()
    {
        $query = Projects::find()->all();
        return $this->render('projects/data', ['Projects' => $query]);

    }

    public function actionProjects()
    {
      //$searchModel = new ProjectsSearch();
      //$searchModel->search(Yii::$app->request->queryParams);

      $dataProvider = new ActiveDataProvider([
        'query' => Projects::find(),
        'pagination' => [
          'pageSize' => 20,
        ],
      ]);

      return $this->render('projects/index', [
          'dataProvider' => $dataProvider,
      ]);
    }

    public function actionDelereqtooc($username, $projectname) {

      $logged_in_user = Yii::$app->user->identity->username;
      if ( $logged_in_user == $username ) {
        if (Requests::findOne(['username' => $username, 'projectname' => $projectname]) == null){ 
            /* If a user deletes their request and refreshes the page, this function will try to delete a nonexistent request and
            throw an exception. Appended this 'if' statement to catch this and redirect user to the projects page.*/
            $dataProvider = new ActiveDataProvider([
                'query' => Projects::find(),
                'pagination' => [
                  'pageSize' => 20,
                ],
              ]);
      
              return $this->render('projects/index', [
                  'dataProvider' => $dataProvider,
              ]);
        }  
        else if(!Requests::findOne(['username' => $username, 'projectname' => $projectname])->delete() ) {
            Yii::$app->getSession()->setFlash('error', 'Error removing your request. Maybe it has already been removed?');
        }else {
            Yii::$app->getSession()->setFlash('success', 'Your request to access ' . Html::beginTag('b') . 
          $projectname . Html::endTag('b') .' has been removed.');
        }

        $dataProvider = new ActiveDataProvider([
          'query' => Projects::find(),
          'pagination' => [
            'pageSize' => 20,
          ],
        ]);

        return $this->render('projects/index', [
            'dataProvider' => $dataProvider,
        ]);
      } else {
            throw new ForbiddenHttpException('You do not have permission to access this page!');
      }
    }


    public function actionRequestooc($username, $projectname) {


      $logged_in_user = Yii::$app->user->identity->username;
      if ( $logged_in_user == $username ) {
        $model = new Requests();
        $model->username = $username;
        $model->projectname = $projectname;
        if( ! Requests::find()->where(['username' => $username])->andWhere(['projectname' => $projectname])->exists()) {
          $model->save();
          Yii::$app->getSession()->setFlash('success', 'Your request to access ' . Html::beginTag('b') . 
          $projectname . Html::endTag('b') .' has been noted and is pending approval.');
        }else {
            /*Yii::$app->getSession()->setFlash('error', 'Your request has either already been added or you do not have permissions.');*/
            // Commented out because error message keeps appearing after page is refreshed- including when project sort is used
        }

        $dataProvider = new ActiveDataProvider([
          'query' => Projects::find(),
          'pagination' => [
            'pageSize' => 20,
          ],
        ]);

        return $this->render('projects/index', [
            'dataProvider' => $dataProvider,
        ]);
      } else {
            throw new ForbiddenHttpException('You do not have permission to access this page!');
      }
    }


    public function actionBackend()
    {
        return $this->render('backend');

    }

    /**
    * Displays Projects page
    * Displays all projects too
    * @return mixed
    */
    public function actionFiles( $projectname )
    {
        return $this->render('projects/files', array('projectname' => $projectname));

    }

    /**
    * Displays Data on projects view - Function not wroking all the way yet
    * @return mixed
    */
    public function actionDisplayData()
    {
        $query = SiteData::find()->all();
        return $this->render('view', array('Datatype' => $query));
    }


    /**
    * Allows to upload files "data"
    * @return mixed
    */
    public function actionData()
    {

        $model = new UploadForm();
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {
                $model->file->saveAs('uploads/' . $model->file->baseName . '.' . $model->file->extension);
            }
        }

        return $this->render('projects', ['model' => $model]);
    }




    // public function createUserOnOwncloud($userId, $password)
    // {
    //     $db_Yii = new yii\db\Connection([
    //         'dsn' => Yii::$app->params['OCDB_connect'],
    //         'username' => Yii::$app->params['OCDB_username'],
    //         'password' => Yii::$app->params['OCDB_password'],
    //         'charset' => 'utf8',
    //     ]);
    //
    //     $db_OC = new yii\db\Connection([
    //         'dsn' => Yii::$app->params['OCDB_connect'],
    //         'username' => Yii::$app->params['OCDB_username'],
    //         'password' => Yii::$app->params['OCDB_password'],
    //         'charset' => 'utf8',
    //     ]);
    //
    //     $post = Yii::$app->db_OC->createCommand('SELECT * FROM oc_users WHERE uid=:uid')
    //                 ->bindValue(':uid', $userId)
    //
    //
    //
    //
    //
    // /*$client = new WebClient();
    //   $response = $client->createRequest()
    //     ->setMethod('post')
    //     ->setUrl(Yii::$app->params['OCS'] . 'users')
    //     ->setData(['userid' => $userId, 'password' => $password])
    //     ->setOptions(['timeout' => 5,])
    //     ->send();
    //     error_log("RESPONSE IS: " . json_encode($response));
    //     return true;*/
    // }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
