<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Credentials */

$this->title = $model->UID;
$this->params['breadcrumbs'][] = ['label' => 'Credentials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="credentials-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'UID' => $model->UID, 'PID' => $model->PID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'UID' => $model->UID, 'PID' => $model->PID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'UID',
            'PID',
            'ACL',
        ],
    ]) ?>

</div>
