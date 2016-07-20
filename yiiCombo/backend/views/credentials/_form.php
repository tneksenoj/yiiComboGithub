<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\User;
use backend\models\Projects;

/* @var $this yii\web\View */
/* @var $model backend\models\Credentials */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="credentials-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'UID')->dropDownlist(ArrayHelper::map(User::find()->all(), 'id', 'username'),
        ['prompt' => 'Select User'])->label('User')?>


    <?= $form->field($model, 'PID')->dropDownlist(ArrayHelper::map(Projects::find()->all(), 'PID', 'Name'),
        ['prompt' => 'Select Project'])->label('Project Title')?>

    <!-- <?= $form->field($model, 'ACL')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
