<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OcShare */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oc-share-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'file_target')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'share_with')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'permissions')->textInput() ?>



    <!-- <?= $form->field($model, 'share_type')->textInput() ?>

    <?= $form->field($model, 'uid_owner')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uid_initiator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent')->textInput() ?>

    <?= $form->field($model, 'item_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'item_source')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'item_target')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file_source')->textInput() ?>

    <?= $form->field($model, 'stime')->textInput() ?>

    <?= $form->field($model, 'accepted')->textInput() ?>

    <?= $form->field($model, 'expiration')->textInput() ?>

    <?= $form->field($model, 'token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mail_send')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
