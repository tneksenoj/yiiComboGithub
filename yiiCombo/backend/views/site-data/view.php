<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SiteData */

$this->title = $model->DID;
$this->params['breadcrumbs'][] = ['label' => 'Site Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-data-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'DID' => $model->DID, 'PID' => $model->PID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'DID' => $model->DID, 'PID' => $model->PID], [
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
            'DID',
            'PID',
            'Location',
        ],
    ]) ?>

</div>
