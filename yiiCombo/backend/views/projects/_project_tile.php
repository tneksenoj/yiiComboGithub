<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ListView;
use backend\models\Projects;
use backend\models\User;
use backend\models\Requests;
?>

<div class="w3-col s12 m4 l3 w3-margin-bottom w3-padding">
    <div class="w3-card-8 w3-center" >
      <?php echo "<a href = '" . Yii::getAlias('@web') . "/index.php/projects/view?id=". $model->PID . "' >" ; ?>
        <div class="w3-container sii-fileimage-icon" style="background-image:url(<?php echo Yii::getAlias('@web') . "/" . $model->logo ?>);">
        </div>
        <div class="w3-container w3-center" >
            <h4><b><div class="sii-filename-elips"><?php echo $model->Name; ?></div> </b></h4>
            <?php echo Html::a('', ['delete', 'id' => $model->PID], [
            'class' => 'glyphicon glyphicon-trash',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ]]); ?>
          </div>
        </a>
    </div>
</div>
