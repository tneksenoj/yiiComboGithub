<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Credentials */

$this->title = 'Create Credentials';
$this->params['breadcrumbs'][] = ['label' => 'Credentials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="credentials-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
