<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\FollowerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Followers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="follower-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Follower', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_account',
            'id_follower',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
