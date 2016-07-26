<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

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
        <!-- <?= Html::a('Create Oc Share', ['create'], ['class' => 'btn btn-success']) ?> -->
    </p>


    <?=Html::beginForm(['requests/setpermissions'], 'post'); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'share_with',
            'file_target',
            //'permissions',
            //'permlist',
            //'id',
            //'share_type',
            //'uid_owner',
            //'uid_initiator',
            // 'parent',
            // 'item_type',
            // 'item_source',
            // 'item_target',
            // 'file_source',
            // 'stime:datetime',
            // 'accepted',
            // 'expiration',
            // 'token',
            // 'mail_send',
            [
                'attribute' => 'Permissions',
                'format' => 'raw',
                'value' => function($model, $key, $index, $grid) {
                  $model->permlist = Array();

                  $labels = ['Read', 'Update', 'Create', 'Delete', 'Share'];

                  $p = $model->permissions;
                  for($i = 0; $i < 5; $i = $i+1) {
                      if ($p%2) {
                        // error_log("#model->permlist: " . $model->permlist[$i]);
                          $ret = ($i==0) ?  $labels[$i] : $ret . ", " . $labels[$i];
                      }
                      $p = intdiv( $p, 2 );
                    }
                    return $ret;

                  },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Options',
                'template' => '{update} {delete}',
            ],
        ],

    ]); ?>
    <?=Html::endForm(); ?>


</div>
