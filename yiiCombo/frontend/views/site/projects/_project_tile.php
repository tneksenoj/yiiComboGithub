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
use backend\models\OcShare;

$projectname = $model->Name;
$status_requested = Requests::find()->where(['projectname' => $projectname])->andWhere(['username' => $username])->exists();
$status_approved = OcShare::find()->where(['share_type' => 0, 'share_with' => $username, 'file_target' => '/'.$projectname])->exists();
$cloudurl = 'https://' . $_SERVER["SERVER_NAME"] . '/owncloud/index.php/apps/files/?dir=%2F' . $projectname;
?>
<meta name="viewport" content="width=device-width, initial-scale=1">


<div class="w3-col s12 m4 l3 w3-margin-bottom w3-padding">
    <div class="w3-card-8 w3-center" >
      <!-- <?php echo "<a href = '" . Yii::getAlias('@web') . "/index.php/site/view?id=". $model->PID . "' >" ; ?> -->
        <div onclick="document.getElementById('id_<?php echo $model->Name?>').style.display='block';">
          <div class="w3-container sii-fileimage-icon" style="background-image:url(<?php echo Yii::getAlias('@web') . "/" . $model->logo ?>);">
          </div>
        </div>
        <div class="w3-container w3-center" >
            <h4><b><div class="sii-filename-elips"><?php echo $model->Name; ?></div> </b></h4>
            <h6><b><div class="sii-filename-elips"><?php echo $model->System; ?></div> </b></h6>
            <?php

                if ($status_approved) {
                    echo '<a href="'. Url::to( $cloudurl , true) .'" class="glyphicon glyphicon-folder-open" target="_blank" >&nbsp;Access Files</a>';
                } else if ($status_requested) {
                    echo Html::a(' Access Requested',
                                 ['site/delereqtooc',
                                  'username' => $username,
                                  'projectname' => $model->Name],
                                 ['class' => 'glyphicon glyphicon-check' ]);
                } else {
                    echo Html::a(' Request Access',
                                 ['site/requestooc',
                                  'username' => $username,
                                  'projectname' => $model->Name],
                                 ['class' => 'glyphicon glyphicon-unchecked']);
                }
            ?>
        </div>
      <div id="id_<?php echo $model->Name?>" class="w3-modal">
        <div class="w3-modal-content w3-animate-top w3-card-8">
          <header class="w3-container" style="background-color:#0086b3; color:white">
            <span onclick="document.getElementById('id_<?php echo $model->Name?>').style.display='none';" class="w3-closebtn">&times;</span>
            <h2>Project: <?php echo $model->Name ?></h2>
          </header>
          <div class="w3-container">
            <p><?php echo $model->Description; ?></p>
          </div>
          <footer class="w3-container" style="background-color:#0086b3; color:white">
            <p>System: <?php echo $model->System ?></p>
          </footer>
        </div>
      </div>
    </div>
</div>
