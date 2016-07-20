<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Requests */

$this->title = 'Update Requests: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'username' => $model->username, 'projectname' => $model->projectname]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="requests-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
