<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ContributionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contributions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contributions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Contributions', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'UID',
            'DID',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
