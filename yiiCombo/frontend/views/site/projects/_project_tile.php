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



$projectname = $model->Name;
$status_requested = Requests::find()->where(['projectname' => $projectname])->andWhere(['username' => $username])->exists();
$status_approved = in_array( $projectname, $groups );

?>

<div class="w3-col s12 m4 l3 w3-margin-bottom w3-padding">
    <div class="w3-card-8 w3-center" >
      <?php echo "<a href = '" . Yii::getAlias('@web') . "/index.php/site/view?id=". $model->PID . "' >" ; ?>
        <div class="w3-container sii-fileimage-icon" style="background-image:url(<?php echo Yii::getAlias('@web') . "/" . $model->logo ?>);">
        </div>
        <div class="w3-container w3-center" >
            <h4><b><div class="sii-filename-elips"><?php echo $model->Name; ?></div> </b></h4>
            <?php 
                if ($status_approved) {
                    echo Html::a('', 
                                 ['/site/files',
                                  'projectname' => $projectname],
                                 ['class' => 'glyphicon glyphicon-folder-open' ]);    
                } else if ($status_requested) {
                    echo Html::a('', 
                                 ['site/delereqtooc',
                                  'username' => $username,
                                  'projectname' => $model->Name],
                                 ['class' => 'glyphicon glyphicon-check' ]);    
                } else {
                    echo Html::a('', 
                                 ['site/requestooc',
                                  'username' => $username,
                                  'projectname' => $model->Name],
                                 ['class' => 'glyphicon glyphicon-unchecked']);
                }
              if ($status) {            
              } else {

              }
            ?>
        </div>
    </div>
</div>
