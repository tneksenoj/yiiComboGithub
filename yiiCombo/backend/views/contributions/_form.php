<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Contributions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contributions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'UID')->textInput() ?>

    <?= $form->field($model, 'DID')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
