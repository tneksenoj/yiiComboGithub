<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Contributions */

$this->title = 'Create Contributions';
$this->params['breadcrumbs'][] = ['label' => 'Contributions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contributions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
