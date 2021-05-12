<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use frontend\models\Comments;
use frontend\models\Likes;
use frontend\models\Follower;
use common\models\User;

$this->title = 'About';
?>


<style>
    .children {
    border: 1px solid green;
    width: fit-content;
    }

    /* body {
        background-color: #eeeeee;
    } */

    .h7 {
        /* font-size: 0.8rem; */
    }

    .gedf-wrapper {
        margin-top: 0.97rem;
    }

    @media (min-width: 992px) {
        .gedf-main {
            padding-left: 4rem;
            padding-right: 4rem;
        }
        .gedf-card {
            margin-bottom: 2.77rem;
        }
    }

    /**Reset Bootstrap*/
    .dropdown-toggle::after {
        content: none;
        display: none;
    }

    body{
        margin-top:20px;
        color: #1a202c;
        text-align: left;
        background-color: #e2e8f0;    
    }
    .main-body {
        padding: 15px;
    }
    .card {
        box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0 solid rgba(0,0,0,.125);
        border-radius: .25rem;
    }

    .card-body {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 1rem;
    }

    .gutters-sm {
        margin-right: -8px;
        margin-left: -8px;
    }

    .gutters-sm>.col, .gutters-sm>[class*=col-] {
        padding-right: 8px;
        padding-left: 8px;
    }
    .mb-3, .my-3 {
        margin-bottom: 1rem!important;
    }

    .bg-gray-300 {
        background-color: #e2e8f0;
    }
    .h-100 {
        height: 100%!important;
    }
    .asd {
        height: 100%!important;
    }
    .shadow-none {
        box-shadow: none!important;
    }
</style>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
        crossorigin="anonymous">
        
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

<div class="site-about">
          <div class="row gutters-sm">
            <div class="col-md-3 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                    <?php $model = User::find()->where(['id' => Yii::$app->user->identity->id])->one(); ?>
                      <h4><?= $model->name ?></h4>
                      <p class="text-secondary mb-1">@<?= $model->username ?></p>
                      <p class="text-muted font-size-sm"><?= $model->email ?></p>
                      <?php if($model->id != Yii::$app->user->identity->id){ ?>
                          <?php $following_cek = Follower::find()->where(['id_account' => $model->id])->andWhere(['id_follower' => Yii::$app->user->identity->id])->one(); ?>
                        <?php if($following_cek != null){ ?>
                          <?= Html::a('Unfollow', ['/follower/follow', 'id'=>$model->id], ['class'=>'btn btn-primary']) ?>
                        <?php }else{ ?>
                          <?= Html::a('Follow', ['/follower/follow', 'id'=>$model->id], ['class'=>'btn btn-primary']) ?>
                        <?php } ?>
                      <?php } ?>
                      <?php if($model->id == Yii::$app->user->identity->id){ ?>
                          <button class="btn btn-outline-primary">Edit Profile</button>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
              <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <?php $follower = Follower::find()->where(['id_account' => $model->id])->count(); ?>
                                <div class="h6 text-muted">Followers</div>
                                <div class="h5"><?= $follower ?></div>
                            </li>
                            <li class="list-group-item">
                                <?php $following = Follower::find()->where(['id_follower' => $model->id])->count(); ?>
                                <div class="h6 text-muted">Following</div>
                                <div class="h5"><?= $following ?></div>
                            </li>
                        </ul>
                </div>
                </div>
            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                    
                    <div class="card gedf-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mr-2">
                                        <img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="">
                                    </div>
                                    <div class="ml-2">
                                        <div class="h5 m-0">dd</div>
                                        <div class="h7 text-muted"> asd</div>
                                    </div>
                                </div>
                                
                            </div>

                        </div>
                        <div class="card-body">
                            
       
                        </div>
                        <div class="card-footer">
                            <a href="#>" class="card-link"><i class="fa fa-gittip">dd</a>
                            <a href="#>" class="card-link"><i class="fa fa-comment">sss</a>
                        </div>
                    </div>
          

                </div>
              </div>
            </div>
          </div>
</div>
