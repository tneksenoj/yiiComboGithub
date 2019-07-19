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
use kartik\icons\Icon;
Icon::map($this);
$projectname = $model->Name;
$status_requested = Requests::find()->where(['projectname' => $projectname])->andWhere(['username' => $username])->exists();
$status_approved = OcShare::find()->where(['share_type' => 0, 'share_with' => $username, 'file_target' => '/'.$projectname])->exists();
$cloudurl = 'https://' . $_SERVER["SERVER_NAME"] . '/owncloud/index.php/apps/files/?dir=%2F' . $projectname;
?>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
  html, body { /* Prevents scrollbar from shifting the page. Use for all scrolling pages. */
    margin-right: -1px; /*COMPENSATES THE VERTICAL SCROLLBAR*/
    overflow-x: hidden; /*REMOVES HORIZONTAL SCROLLBAR THE ABOVE CREATES*/
    margin-top: 0px; /*COMPENSATES THE HORIZONTAL SCROLLBAR*/
}
</style>


<div class="w3-col s12 m4 l3 w3-margin-bottom w3-padding">
    <div class="w3-card-8 w3-center" >
      <!-- <?php echo "<a href = '" . Yii::getAlias('@web') . "/index.php/site/view?id=". $model->PID . "' >" ; ?> -->
      <div onclick="document.getElementById('id_<?php echo $model->Name?>').classList.add('activeModal'); 
      document.getElementById('modal_<?php echo $model->Name?>').classList.add('openModal');"> 

          <div class="w3-container sii-fileimage-icon" style="background-image:url(<?php echo Yii::getAlias('@web') . "/" . $model->logo ?>);">
          </div>

        </div>
        <div class="w3-container w3-center" >
            <h4><b><div id="projectTitle" class="sii-filename-elips"><?php echo $model->Name; ?></div> </b></h4>
            <h6><b><div id="projectSystem" class="sii-filename-elips"><?php echo $model->System; ?></div> </b></h6>
            <?php             
                if ($status_approved) {
                  echo '<a href="' . Url::to($cloudurl, true) . '" class="svgicon" target="_blank" title="Open Files" data-toggle="tooltip">' . 
                  Icon::show('external-link-alt') . '&nbsp;Open </a>'; 
                
                }else if ($status_requested) {
                echo Html::a(Icon::show('check-square').'&nbsp;Pending', ['site/delereqtooc', 'username' => $username, 'projectname'=>$model->Name], [
                  'class' => 'svgicon', 'title' => 'Pending Approval', 'data-toggle' => 'tooltip']); 
                
                }else {
                echo Html::a(Icon::show('square').'&nbsp;Request', ['site/requestooc', 'username' => $username, 'projectname'=>$model->Name], [
                  'class' => 'svgicon', 'title' => 'Request Access', 'data-toggle' => 'tooltip']);}     
            ?>
          <div id="projectId" data-toggle="tooltip" title=<?php /* Adds project ID number to tiles*/ 
          $projId = sprintf('%04d', $model->PID); echo 'ID#' . $projId;?>> 
          <?php $projId = sprintf('%04d', $model->PID); echo '#' . $projId;?>
        </div>
        </div>

      <div id="id_<?php echo $model->Name?>" class="w3-modal modal">
      <!-- -->
        <div id="modalClick" class="modalClick" onclick="document.getElementById('id_<?php echo $model->Name?>').classList.remove('activeModal');
        document.getElementById('modal_<?php echo $model->Name?>').classList.remove('openModal');"> X </div>
        <!-- -->
        <div id="modalClick2" class="modalClick" onclick="document.getElementById('id_<?php echo $model->Name?>').classList.remove('activeModal');
        document.getElementById('modal_<?php echo $model->Name?>').classList.remove('openModal');"> Y </div>
                
        <div id="modal_<?php echo $model->Name?>"class="w3-modal-content w3-animate-top w3-card-8 modalBox"> 
        
        <span onclick="document.getElementById('id_<?php echo $model->Name?>').classList.remove('activeModal');
        document.getElementById('modal_<?php echo $model->Name?>').classList.remove('openModal');" class="w3-closebtn closeX">&times;</span>  
        
        <?php echo Html::img('@web/' . $model->logo, ['alt'=>$model->Name . ' icon', 'class'=>'modalImg']) ?>
          <header class="w3-container modalHeader">
            <h2>Project: <?php echo $model->Name ?></h2>
            <h3>System: <?php echo $model->System ?></h3>
          </header>
          <div class="w3-container modalBody">
          <hr>  
          <p><?php echo $model->Description; ?></p>
          </div>
          <div class="modalFooter">  <?php             
                if ($status_approved) {
                  echo '<a href="' . Url::to($cloudurl, true) . '" class="modalIcon" target="_blank" title="Open Files" data-toggle="tooltip">' . 
                  Icon::show('external-link-alt') . '&nbsp;Open in ownCloud </a>'; 
                
                }else if ($status_requested) { //
                echo Html::tag('div', Icon::show('check-square').'&nbsp;Status: Pending Approval &nbsp;&nbsp;', [
                  'class' => 'modalStatus', 'title' => 'Pending Approval', 'data-toggle' => 'tooltip']); 
                  echo Html::a(Icon::show('times-circle').'&nbsp;Cancel Request', ['site/delereqtooc', 'username' => $username, 'projectname'=>$model->Name], [
                    'class' => 'modalIcon', 'title' => 'Cancel Request', 'data-toggle' => 'tooltip']); 
                
                  }else {
                echo Html::a(Icon::show('square').'&nbsp;Request Access', ['site/requestooc', 'username' => $username, 'projectname'=>$model->Name], [
                  'class' => 'modalIcon', 'title' => 'Request Access', 'data-toggle' => 'tooltip']);}     
            ?> 
            </div>
        </div>
      </div>
    </div>
</div>

