<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Frontend';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php header('Location:Https://' . $_SERVER["SERVER_NAME"] . Yii::getAlias('@web') . '/../../frontend/web/index.php');
	  exit();
?>

<div class="site-files">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
