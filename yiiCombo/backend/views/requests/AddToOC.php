<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Requests */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['AddToOC']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requests-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'username' => $model->username, 'projectname' => $model->projectname], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'username' => $model->username, 'projectname' => $model->projectname], [
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
            'username',
            'projectname',
        ],
    ]) ?>

</div>
