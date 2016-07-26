<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OcShare */

$this->title = 'Update Oc Share: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Oc Shares', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="oc-share-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
