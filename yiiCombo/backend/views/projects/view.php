<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Projects */

$this->title = $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="w3-container icon-view" style="background-image:url(<?php echo Yii::getAlias('@web') . "/" . $model->logo ?>);">
        </div> <br>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->PID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->PID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete project "' . $model->Name . '"?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'PID',
            'Name',
            'System',
            'Description:ntext',
        ],
    ]) ?>

</div>