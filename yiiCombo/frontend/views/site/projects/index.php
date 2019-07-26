<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ListView;
use backend\models\User;

$this->title = 'Browse Projects';
$this->params['breadcrumbs'][] = $this->title;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/* retrieve the username and the groups for this user*/
$username = Yii::$app->user->identity->username;
?>

<!--  This page dynamically generates project tiles with a brief description  -->

    <!--<a class="btn btn-md btn-primary pull-right proj-btn"> View My Projects </a>
    <a class="btn btn-md btn-primary pull-right proj-btn"> Add Project </a>-->


<h1 id='project-header'><?= Html::encode($this->title) ?></h1>
    <div id='projects-index'>
      <div id='project-container' class='w3-container w3-center'>
          <div class='w3-row-padding' style = "max-height:10em">
              <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
              <?= ListView::widget([
                  'dataProvider' => $dataProvider,
                  // 'filterModel' => $searchModel,

                  'layout' => "{sorter}\n{items}\n{summary}\n{pager}",
                  'itemView' => function($model, $key, $index, $column) use ($username) {
                      return $this->render('_project_tile', ['model' => $model,
                                                             'username' => $username,
                                                            ]);
                  },
                  
                  'pager' => [
                    'firstPageLabel' => 'first',
                    'lastPageLabel' => 'last',
                    'nextPageLabel' => 'next',
                    'prevPageLabel' => 'previous',
                    'maxButtonCount' => 3,
                  ],


              ]); ?>

            </div>
        </div>
    </div>
