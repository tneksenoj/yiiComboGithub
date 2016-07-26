<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OcShareSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oc-share-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'share_type') ?>

    <?= $form->field($model, 'share_with') ?>

    <?= $form->field($model, 'uid_owner') ?>

    <?= $form->field($model, 'uid_initiator') ?>

    <?php // echo $form->field($model, 'parent') ?>

    <?php // echo $form->field($model, 'item_type') ?>

    <?php // echo $form->field($model, 'item_source') ?>

    <?php // echo $form->field($model, 'item_target') ?>

    <?php // echo $form->field($model, 'file_source') ?>

    <?php // echo $form->field($model, 'file_target') ?>

    <?php // echo $form->field($model, 'permissions') ?>

    <?php // echo $form->field($model, 'stime') ?>

    <?php // echo $form->field($model, 'accepted') ?>

    <?php // echo $form->field($model, 'expiration') ?>

    <?php // echo $form->field($model, 'token') ?>

    <?php // echo $form->field($model, 'mail_send') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
