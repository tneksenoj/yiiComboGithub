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

<div class="w3-col s12 m4 l3 w3-margin-bottom">
    <div class="w3-card-8 w3-center" >
      <?php echo "<a href = '" . Yii::getAlias('@web') . "/index.php?r=site%2Fview&id=". $model->PID . "' >" ; ?>
        <div class="w3-container sii-fileimage-icon" style="background-image:url(<?php echo  $model->logo ?>);">
        </div>
        <div class="w3-container w3-center" >
            <h4><b><div class="sii-filename-elips"><?php echo $model->Name; ?></div> </b></h4>
            <?php echo Html::a('', ['site/requestooc',
            'username' => Yii::$app->user->identity->username,
            'projectname' => $model->Name],
            ['class' => 'glyphicon glyphicon-plus']); ?>
          </div>
        </a>
    </div>
</div>
