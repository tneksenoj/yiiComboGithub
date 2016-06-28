<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CredentialsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Credentials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="credentials-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Credentials', ['create'], ['class' => 'btn btn-success']) ?>
        <br></br>
        <h4>Use this page to add users to a given project based on thier user ID and project ID.</h4>
        <br></br>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'UID',
            'PID',
            'ACL',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
