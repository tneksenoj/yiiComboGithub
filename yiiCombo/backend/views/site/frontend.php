<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Frontend';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php header('Location:https://' . $_SERVER["SERVER_NAME"] . '/yii/yiiCombo/frontend/web/');
	  exit();
?>

<div class="site-files">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
