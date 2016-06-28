<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\LinkPager;
use backend\models\SiteData;


/* @var $this yii\web\View */
/* @var $model backend\models\Projects */


//This page dynamically updates each project tile making it 'clickable' and will brings it to it's own landing page.

$this->title = $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-view">

    <h1><?= Html::encode($this->title) ?></h1>


      <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'name-display'],
            'attributes' => [
                'Name',   
            ],
        ]) ?>

      <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'description-display'],
            'attributes' => [
                'Description:ntext',   
            ],
        ]) ?>
</div>        



        