<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\OcShare */

$this->title = 'Assign Project Permissions';
$this->params['breadcrumbs'][] = ['label' => 'Oc Shares', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oc-share-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
