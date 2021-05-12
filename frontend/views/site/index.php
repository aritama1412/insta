<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use frontend\models\Comments;
use frontend\models\Follower;
use frontend\models\Likes;
use common\models\User;

$this->title = 'My Insta';
?>
<style>
    .children {
    border: 1px solid green;
    width: fit-content;
    }

    body {
        background-color: #eeeeee;
    }

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

<div class="site-index">
    <div class="body-content">
        <?php if (Yii::$app->user->isGuest) { ?>
        <h3>Harap login terlebih dahulu untuk melihat konten.</h3>
        <?php } else { ?>
            
        <div class="container-fluid gedf-wrapper">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="h5">@<?= Yii::$app->user->identity->username ?></div>
                            <div class="h7 text-muted">Fullname : <?= Yii::$app->user->identity->name ?></div>
                            <div class="h7"><?= Yii::$app->user->identity->hobi ?>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <?php $model = User::find()->where(['id' => Yii::$app->user->identity->id])->one(); ?>
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
                <div class="col-md-6 gedf-main">

                    <!--- \\\\\\\ create Post-->
                    <div class="card gedf-card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="true">Make
                                        a publication</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <!-- <?= Html::beginForm(['/post/create'], 'POST'); ?> -->
                            <?php $form = ActiveForm::begin([
                                'options' => ['enctype'=>'multipart/form-data'],
                                'action' =>['/post/create']
                            ]); ?>


                            <div class="tab-content" id="myTabContent">
                                <div class="" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                                    <div class="form-group">
                   
                                        <label class="sr-only" for="message">post</label>
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Apa pikiran anda?</label>
                                            <?= Html::textarea('postingan', '', ['rows' => 3, 'class'=>'form-control']); ?>
                                        </div>
                                        <!-- <div class="form-group">
                                            <input type="file" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">Upload image</label>
                                        </div> -->
                                        <div class="form-group ">
                                        <!-- <div class="col-xl-12"> -->
                                            <label class="control-label">Upload Gambar</label>
                                            <input type="file" name="file"/>

                                        <!-- </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-toolbar float-right justify-content-between">
                                <div class="btn-group">
                                    <?= Html::submitButton('Post', ['class' => 'btn btn-primary']) ?>
                                </div>
                            </div>

                            <!-- <?= Html::endForm(); ?> -->
                            <?php
                            ActiveForm::end();
                            ?>
                        </div>
                    </div>
                    <!-- Post /////-->

                    <!--- \\\\\\\Post-->
                    <?php foreach($posts as $post){ ?>
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
                                        <div class="h5 m-0"> <a href="/insta/site/profile?id=<?= $post->user->id ?>" class="card-link">@<?= $post->user->username ?></a></div>
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
                            <?php $sumx = Likes::find()->where(['id_post' => $post->id])->COUNT(); ?>
                            <a href="/insta/site/like?id=<?= $post->id ?>" class="card-link"><i class="fa fa-gittip"></i><?= ($sumx!= 0)? ' Likes ('.$sumx.')':' Like'; ?></a>
                            <?php $sum = Comments::find()->where(['id_post' => $post->id])->COUNT(); ?>
                            <a href="/insta/site/view?id=<?= $post->id ?>" class="card-link"><i class="fa fa-comment"></i><?= ($sum!= 0)? ' Comments ('.$sum.')':' Comment'; ?></a>
                        </div>
                    </div>
                    <?php } ?>

                    <!-- Post /////-->

                </div>
                <!-- <div class="col-md-3">
                    <div class="card gedf-card">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                                card's content.</p>
                            <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>
                    <div class="card gedf-card">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                                    card's content.</p>
                                <a href="#" class="card-link">Card link</a>
                                <a href="#" class="card-link">Another link</a>
                            </div>
                        </div>
                </div> -->
            </div>
        </div>            
        
        <?php } ?>


    </div>
</div>
