<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Contributions */

$this->title = $model->UID;
$this->params['breadcrumbs'][] = ['label' => 'Contributions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contributions-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'UID' => $model->UID, 'DID' => $model->DID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'UID' => $model->UID, 'DID' => $model->DID], [
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
            'DID',
        ],
    ]) ?>

</div>
