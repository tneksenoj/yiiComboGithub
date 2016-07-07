<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>

<!--  This page dynamically generates project tiles with a brief description  -->

<div class="site-data">
    <h1><?= Html::encode($this->title) ?></h1>
    <!--<a class="btn btn-md btn-primary pull-right proj-btn"> View My Projects </a>
    <a class="btn btn-md btn-primary pull-right proj-btn"> Add Project </a>-->


        <?php foreach ($Projects as $Project): ?>
            <?php echo "<a href = 'https://ec2-54-218-30-182.us-west-2.compute.amazonaws.com/crab/frontend/web/index.php?r=site%2Fview&id=". $Project->PID . "' class='plink' > <div class= 'project col-md-6'>"; ?>
                <div class="title">
                    <?= Html::encode("{$Project->Name}") ?>:
                </div>
                <div class="description">
                 <?= Html::encode("{$Project->Description}") ?>
                </div>
            </div>
        <?php endforeach; ?>

</div>
