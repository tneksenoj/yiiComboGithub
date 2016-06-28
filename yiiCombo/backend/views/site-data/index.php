<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SiteDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Site Datas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-data-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Site Data', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'DID',
            'PID',
            'Location',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
