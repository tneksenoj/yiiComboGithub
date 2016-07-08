<?php

/* @var $this yii\web\View */

$this->title = 'Center of Excellence for Bioinformatics Research';
?>

<!-- This is the main index (Home) page that everything lands on -->

<div class="site-index" id="sciencebg">

    <div class="jumbotron">
        <img src="<?php echo Yii::getAlias('@web') . '/images/white.png'; ?>">

        <p class="lead" id="dynam">This is a dynamic inter-collegiate biology research sharing platform.</p>
        <p><a class="btn btn-primary btn-lg" href=<?php echo Yii::getAlias('@web') . "/index.php?r=site%2Fabout"; ?>>Learn More</a>
        <a class="btn btn-primary btn-lg" href=<?php echo Yii::getAlias('@web') . "/index.php/signup?r=site%2Fsignup"; ?>>Request Access</a></p>
    </div>

</div>
