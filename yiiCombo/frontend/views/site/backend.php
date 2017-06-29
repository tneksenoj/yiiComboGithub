<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Backend';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php header('Location:Https://' . $_SERVER["SERVER_NAME"] . Yii::getAlias('@web') . '/../../backend/web/index.php');
	  exit();
?>

<!--https://www.sharebio.org/owncloud-->
<!--  This page dynamically generates project tiles with a brief description  -->

<div class="site-files">
    <h1><?= Html::encode($this->title) ?></h1>
    <!--<a class="btn btn-md btn-primary pull-right proj-btn"> View My Projects </a>
    <a class="btn btn-md btn-primary pull-right proj-btn"> Add Project </a>-->
<!--     <iframe src="https://www.sharebio.org/owncloud" width="1140" height="700">
      </iframe> -->

      <!--<object data=https://www.sharebio.org/owncloud width="1140" height="700"> <embed src=https://www.sharebio.org/owncloud width="1140" height="700"> </embed></object>-->


</div>
