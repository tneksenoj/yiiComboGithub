<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Credentials */

$this->title = 'Update Credentials: ' . $model->UID;
$this->params['breadcrumbs'][] = ['label' => 'Credentials', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->UID, 'url' => ['view', 'UID' => $model->UID, 'PID' => $model->PID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="credentials-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
