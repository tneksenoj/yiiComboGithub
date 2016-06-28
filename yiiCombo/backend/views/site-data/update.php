<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SiteData */

$this->title = 'Update Site Data: ' . $model->DID;
$this->params['breadcrumbs'][] = ['label' => 'Site Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->DID, 'url' => ['view', 'DID' => $model->DID, 'PID' => $model->PID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="site-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
