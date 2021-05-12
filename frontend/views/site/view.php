<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use frontend\models\Comments;
use common\models\User;
use frontend\models\Likes;

$this->title = 'Comment';
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

            <div class="col-md-8 asd">
              <div class="card mb-3">
                <div class="card-body">
                    <div class="card gedf-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mr-2">
                                        <?php if($post->user->pp != null){ ?>
                                            <img class="rounded-circle" width="45" src="<?= Yii::$app->request->baseUrl . '/frontend/web/img/' . $post->user->pp ?>" alt="">
                                        <?php }else{ ?>
                                            <img class="rounded-circle" width="45" src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="">
                                        <?php } ?>
                                    </div>
                                    <div class="ml-2">
                                        <div class="h5 m-0">@<?= $post->user->username ?></div>
                                        <div class="h7 text-muted"><?= $post->user->name ?></div>
                                    </div>
                                </div>
                                
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i> <?=date("d M Y - H:i", strtotime($post->date_created));  ?></div>
                            
                            <?php if($post['img'] != null){ ?>
                            <?= Html::img('@web/img/'.$post['img'] , ['alt'=>'some', 'style' => 'width:50%;', 'class'=>'responsive']);?>
                            <?php }else{ } ?>
                            <p class="card-text">
                                <?= $post['content'] ?>
                            </p>
                        </div>
                        <div class="card-footer">
                            <?php $sum = Likes::find()->where(['id_post' => $post->id])->COUNT(); ?>
                            <a href="/insta/site/like?id=<?= $post->id ?>" class="card-link"><i class="fa fa-gittip"></i><?= ($sum!= 0)? ' Likes ('.$sum.')':' Like'; ?></a>
                        </div>
                        <?php if($comments != null){ ?>
                            <?php foreach($comments as $comment){ ?>
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="mr-2">
                                            <?php if($comment->user->pp != null){ ?>
                                                <img class="rounded-circle" width="45" src="<?= Yii::$app->request->baseUrl . '/frontend/web/img/' . $comment   ->user->pp ?>" alt="">
                                            <?php }else{ ?>
                                                <img class="rounded-circle" width="45" src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="">
                                            <?php } ?>
                                            </div>
                                            <div class="ml-2">
                                                <div class="h5 m-0"> <a href="/insta/site/profile?id=<?= $comment->user->id ?>" class="card-link">@<?= $comment->user->username ?></a></div>
                                                <div class="h7 text-muted"><?= $comment->user->name ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="card-body">
                                    <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i> <?=date("d M Y - H:i", strtotime($comment->date_created));  ?></div>
                                    <p class="card-text">
                                        <?= $comment['comment'] ?>
                                    </p>
                                </div>
                            <?php } ?>
                        <?php } ?>

                        <?php $form = ActiveForm::begin([
                                'options' => ['enctype'=>'multipart/form-data'],
                                'action' =>['/comments/create?id='.$post->id]
                        ]); ?>
                        <div class="form-group" style="margin-left: 10px; margin-right: 10px;">
                            <label for="exampleFormControlTextarea1">Berikan komentar anda</label>
                            <?= Html::textarea('postingan', '', ['rows' => 3, 'class'=>'form-control']); ?>
                        <div class="btn-toolbar float-right justify-content-between" style="margin-top: 5px; margin-bot: 5px;">
                            <div class="btn-group">
                                <?= Html::submitButton('Comment', ['class' => 'btn btn-primary']) ?>
                            </div>
                        </div>
                        <?php
                            ActiveForm::end();
                            ?>
                        </div>

                    </div>

                </div>
              </div>
            </div>
          </div>
</div>
