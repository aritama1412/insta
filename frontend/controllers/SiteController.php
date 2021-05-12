<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Post;
use frontend\models\Comments;
use frontend\models\Likes;
use common\models\User;
use yii\web\UploadedFile;  

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $posts = Post::find()->orderBy(['date_created' => SORT_DESC])->all();

        if(Yii::$app->request->post()){
            $model = new Post();

            // var_dump(Yii::$app->request->post()); die;
            // if ($model->load(Yii::$app->request->post())) {
                $model->id_user = Yii::$app->user->identity->id;
                $model->content = Yii::$app->request->post()['postingan'];
                $model->date_created = date("Y-m-d H:i:s");
                $model->save(false);
                // var_dump($model); die;

                return $this->render('index', [
                    'posts' => $posts,
                ]);
            // }

        }


        return $this->render('index', [
            'posts' => $posts,
        ]);
    }

    public function actionProfile($id)
    {
        // $id = Yii::$app->user->identity->id;
        $model = User::find()->where(['id' => $id])->one();
        $posts = Post::find()->where(['id_user' => $id])->orderBy(['date_created' => SORT_DESC])->all();
        return $this->render('profile', [
            'model' => $model,
            'posts' => $posts,
        ]);
    }
    
    public function actionEdit_profile($id)
    {
        // $id = Yii::$app->user->identity->id;
        // $model = User::find()->where(['id' => $id])->one();
        $post = Post::find()->where(['id' => $id])->one();
        $comments = Comments::find()->where(['id_post' => $id])->all();

        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            $model = User::find()->where(['id' => $id])->one();
            $model->name = ($data['name'] != null)? $data['name']: $model->name;
            $model->email = ($data['email'] != null)? $data['email']: $model->email;
            $model->hobi = ($data['hobi'] != null)? $data['hobi']: $model->hobi;

            $photo = UploadedFile::getInstanceByName('file');
            // var_dump($photo); die;

            if ($photo) {
                $timeFile = strtotime("now");
                $basePath = Yii::getAlias('@frontend/');
                $uploadDir = 'web/img/';
                if (!file_exists($basePath . 'web/img')) {
                    mkdir($basePath . 'web/img', 0777, true);
                }
                if ($model->pp != "") {
                    if (\file_exists($basePath . $uploadDir . $model->pp)) {
                        unlink($basePath . $uploadDir . $model->pp);
                    }
                }
                $nama_ = substr($photo->name, 0, 20);
                $namaFile =   "img_" . str_replace(" ", "", $nama_) . "_". $timeFile;
                $saved = $photo->saveAs($basePath . $uploadDir . $namaFile  . '.' . $photo->extension);
                if (!$saved) {
                    die();
                }
                $model->pp = $namaFile.'.'.$photo->extension;
            }
            
            $model->save(false);

            $model = User::find()->where(['id' => $id])->one();
            $posts = Post::find()->where(['id_user' => $id])->orderBy(['date_created' => SORT_DESC])->all();

            return $this->render('profile', [
                'model' => $model,
                'posts' => $posts,
            ]);
        }

        return $this->render('edit_profile', [
            'comments' => $comments,
            'post' => $post,
        ]);
    }

    public function actionView($id)
    {
        // $id = Yii::$app->user->identity->id;
        // $model = User::find()->where(['id' => $id])->one();
        $post = Post::find()->where(['id' => $id])->one();
        $comments = Comments::find()->where(['id_post' => $id])->all();
        return $this->render('view', [
            'comments' => $comments,
            'post' => $post,
        ]);
    }


    public function actionLike($id)
    {
        // $id = Yii::$app->user->identity->id;
        // $model = User::find()->where(['id' => $id])->one();
        $post = Post::find()->where(['id' => $id])->one();
        $cek_likes = Likes::find()->where(['id_post' => $id])->andWhere(['id_user' => Yii::$app->user->identity->id])->one();
        if($cek_likes == null){
            $likes = New Likes();
            $likes->id_post = $id;
            $likes->id_user = Yii::$app->user->identity->id;
            $likes->save();
        }else{
            $cek_likes->delete();
        }


        return $this->redirect(Yii::$app->request->referrer);

    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
