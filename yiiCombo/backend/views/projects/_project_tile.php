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
use kartik\icons\Icon;
Icon::map($this);
?>

<div class="w3-col s12 m4 l3 w3-margin-bottom w3-padding">
    <div class="w3-card-8 w3-center" >
      <?php echo "<a href = '" . Yii::getAlias('@web') . "/index.php/projects/view?id=". $model->PID . "' >" ; ?>
        <div class="w3-container sii-fileimage-icon"  data-toggle="tooltip" title= <?php echo $model->Name?> 
        style="background-image:url(<?php echo Yii::getAlias('@web') . "/" . $model->logo ?>);">
        </div>
        <div class="w3-container w3-center" id="adiv" >
            <h4><b><div id="projectTitle" class="sii-filename-elips"><?php echo $model->Name; ?></div></b></h4>
            <h6><div id="projectSystem" class="sii-filename-elips"><?php echo $model->System; ?></div></h6>            
            <!-- Changed trashcan icon to use Font Awesome svg, shifted left -->
           <?php echo Html::a(Icon::show('trash'), ['delete', 'id' => $model->PID], [
            'class' => 'svgicon', 'data-toggle' => 'tooltip', 'title' => 'Delete', 'id' => 'delete', 
            'data' => [
                'title' => 'Delete Project',
                'confirm' => 'Are you sure you want to delete project ' . $model->Name . '?', /* Shows which project */
                'class' => 'btn-danger',
                'method' => 'post',
            ],
        ]);?>
          <?php echo Html::a(Icon::show('pen'), ['update', 'id' => $model->PID], [
            'class' => 'svgicon', 'data-toggle' => 'tooltip', 'title'=>'Update', 'id'=>'update',
          ]);?>

          <div id="projectId" data-toggle="tooltip" title=<?php /* Adds project ID number to tiles*/ 
          $projId = sprintf('%04d', $model->PID); echo 'ID#' . $projId;?>> 
          <?php $projId = sprintf('%04d', $model->PID); echo '#' . $projId;?>
          </div>
        </div>
    </div>
</div>