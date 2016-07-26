<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OcShare */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    $p = $model->permissions;
    for($i = 0; $i < 5; $i = $i+1) {
        if ($p%2) {
            $model->permlist[$i] = pow(2, $i);
        }else {
          $model->permlist[$i] = 0;
        }
        $p = intdiv( $p, 2 );
      }
  ?>


<div class="oc-share-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'file_target')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'share_with')->textInput(['maxlength' => true]) ?>
    <!-- <?= $form->field($model, 'permissions')->textInput(['maxlength' => true]) ?> -->

    <?= $form->field($model, 'permlist')->checkboxList([1 => 'Read', 2 => 'Update', 4 => 'Create', 8 => 'Delete', 16 => 'Share'], []) ?>



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
