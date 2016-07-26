<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OcShareSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Oc Shares';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oc-share-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Oc Share', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'file_target',
            //'id',
            //'share_type',
            'share_with',
            //'uid_owner',
            //'uid_initiator',
            // 'parent',
            // 'item_type',
            // 'item_source',
            // 'item_target',
            // 'file_source',
            'permissions',
            // 'stime:datetime',
            // 'accepted',
            // 'expiration',
            // 'token',
            // 'mail_send',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
