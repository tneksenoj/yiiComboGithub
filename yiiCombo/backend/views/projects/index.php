<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ListView;

$this->title = 'Existing Projects';
$this->params['breadcrumbs'][] = $this->title;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<!--  This page dynamically generates project tiles with a brief description  -->

<h1><?= Html::encode($this->title) ?></h1>

<p>&nbsp;&nbsp;&nbsp;&nbsp;<?= Html::a('Create a Project', ['create'], ['class' => 'btn btn-primary']) ?></p>

    <div class="projects-index">
      <div class='w3-container w3-center'>
              <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
              <?= ListView::widget([
                  'dataProvider' => $dataProvider,
                  // 'filterModel' => $searchModel,
                  'layout' => "{sorter}\n{summary}\n{items}\n{pager}",
                  'itemView' => function($model, $key, $index, $column) {
                      return $this->render('_project_tile', ['model' => $model]);
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
