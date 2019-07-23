<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use frontend\assets\AppAsset;
use frontend\assets\W3schoolsAsset;
use frontend\assets\SiiAsset;
use frontend\assets\FontAsset;

FontAsset::register($this);
AppAsset::register($this);
W3schoolsAsset::register($this);
SiiAsset::register($this);

$js = <<<SCRIPT
/* To initialize BS3 tooltips set this below */
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
});;
/* To initialize BS3 popovers set this below */
$(function () { 
    $("[data-toggle='popover']").popover(); 
});
/* For modal navigation */
$(document).keydown(
    var modalProj = getElementById('id_<?php echo ?>'); /* .style.display='block';*/
    function(e)
    {    
        if (e.keyCode == 39) {      
        modalProj.nextSibling.style.display='block';    

        }
        if (e.keyCode == 37) {      
/*            $(".move:focus").prev().focus();
*/
        }
    }
);

SCRIPT;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" type="image/ico" href= "<?php echo Yii::getAlias('@web') . '/images/favicon.ico'; ?>">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/images/sharebio-light.png', ['id'=>'sharebio-icon']), //Sharebio logo on left navbar
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    ?>

    <?php
    //These are the items used in the main bar
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'Projects', 'url' => ['/site/projects']],
        //['label' => 'Files', 'url' => ['/site/files/']],
        //['label' => 'Requests', 'url' => ['/requests/index']],
        //['label' => 'Data', 'url' => ['/site/data']],
        //['label' => 'CreateProjects', 'url' => ['/site/createProject']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->can('admin')) {
        $menuItems[] = ['label' => 'Backend', 'url' => ['backend']];
    }
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Center of Excellence for Bioinformatics Research <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
