<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RequestsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requests-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Requests', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
            'projectname',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{addtooc} {delete}',
                'buttons' => [
                    'addtooc' => function ($url, $model, $key) {
                      //$url = '/yii/yiiCombo/backend/web/index.php/requests/AddToOC/'. $model->username . '/' .$model->projectname;
                        return Html::a(
                            '<span class="glyphicon glyphicon-plus"></span>',
                            $url,
                            [
                                'title' => 'addtooc',
                                'data-pjax' => '0',
                            ]
                        );
                    },
                ],
            ],

        ],
    ]); ?>
</div>
