<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Files';
$this->params['breadcrumbs'][] = $this->title;
?>

<!--  This page dynamically generates project tiles with a brief description  -->

<div class="site-files">
    <h1><?= Html::encode($this->title) ?></h1>
    <!--<a class="btn btn-md btn-primary pull-right proj-btn"> View My Projects </a>
    <a class="btn btn-md btn-primary pull-right proj-btn"> Add Project </a>-->

    <iframe src="http://localhost/owncloud" width="1140" height="700">
      </iframe>

</div>