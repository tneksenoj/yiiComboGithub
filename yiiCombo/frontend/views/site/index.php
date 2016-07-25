<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */

$this->title = 'Center of Excellence for Bioinformatics Research';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- This is the main index (Home) page that everything lands on -->

<div class="site-index" id="sii-sciencebg">
  <div class="w3-row">
    <div class="w3-full spacer"> 
    </div>
    <div class="w3-row">
      <div class="w3-full w3-center"> 
        <div class="w3-container">
          <img id="sii-splash-image" src="<?php echo Yii::getAlias('@web') . '/images/white.png'; ?>" width="622" height="131">
        </div>
      </div> 
      <div class="w3-full w3-center">
          <h4 id="sii-dynam">This is a dynamic inter-collegiate biology research sharing platform.</h4>
          <p><a class="btn btn-primary btn-lg" href=<?php echo Yii::getAlias('@web') . "/index.php?r=site%2Fabout"; ?>>Learn More</a>
          <a class="btn btn-primary btn-lg" href=<?php echo Yii::getAlias('@web') . "/index.php/signup?r=site%2Fsignup"; ?>>Request Access</a></p>
      </div>
    </div>
  </div>
</div>
