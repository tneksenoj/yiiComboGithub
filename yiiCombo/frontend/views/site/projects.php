 <?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- This page generates the form for file upload form the front end. - disabled in the alpha stage of project -->

<div class="site-projects">
	<h1><?= Html::encode($this->title) ?></h1>
	<p>If you want to upload data or a project please fill out the form.</p>


	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	<?= $form->field($model, 'file')->fileInput() ?>

	<button>Submit</button>

	<?php ActiveForm::end(); ?>

</div>






