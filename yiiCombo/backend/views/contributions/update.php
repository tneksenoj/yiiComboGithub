<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Contributions */

$this->title = 'Update Contributions: ' . $model->UID;
$this->params['breadcrumbs'][] = ['label' => 'Contributions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->UID, 'url' => ['view', 'UID' => $model->UID, 'DID' => $model->DID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="contributions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
