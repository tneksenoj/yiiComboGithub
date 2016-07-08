<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>

<!--  This page dynamically generates project tiles with a brief description  -->


    <h1><?= Html::encode($this->title) ?></h1>
    <!--<a class="btn btn-md btn-primary pull-right proj-btn"> View My Projects </a>
    <a class="btn btn-md btn-primary pull-right proj-btn"> Add Project </a>-->
    <div class='w3-container w3-center'>
        <div class='w3-row-padding' style = "max-height:10em">
            <?php foreach ( $Projects as $file ): ?>
                <div class="w3-col s12 m4 l3 w3-margin-bottom">
                    <div class="w3-card-8 w3-center" >
                      <?php echo "<a href = '" . Yii::getAlias('@web') . "/index.php?r=site%2Fview&id=". $file->PID . "' >" ; ?>
                        <div class="w3-container sii-fileimage-icon" style="background-image:url(<?php echo  $file->logo ?>);">
                        </div>
                        <div class="w3-container w3-center" >
                            <h4><b><div class="sii-filename-elips"><?php echo $file->Name; ?></div> </b></h4>
                          </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
