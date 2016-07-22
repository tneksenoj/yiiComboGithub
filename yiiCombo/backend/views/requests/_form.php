<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\User;
use backend\models\Projects;

/* @var $this yii\web\View */
/* @var $model frontend\models\Requests */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="requests-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'username')->dropDownlist(ArrayHelper::map(User::find()->all(), 'username', 'username'),
        ['prompt' => 'Select User'])->label('User')?>


    <?= $form->field($model, 'projectname')->dropDownlist(ArrayHelper::map(Projects::find()->all(), 'Name', 'Name'),
        ['prompt' => 'Select Project'])->label('Project')?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
