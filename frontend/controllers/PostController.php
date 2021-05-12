<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Post;
use common\models\User;
use frontend\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;  

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post(), '')) {


            $model->id_user = Yii::$app->user->identity->id;
            $model->content = Yii::$app->request->post()['postingan'];
            $model->date_created = date("Y-m-d H:i:s");
            
            $photo = UploadedFile::getInstanceByName('file');

            if ($photo) {
                $timeFile = strtotime("now");
                $basePath = Yii::getAlias('@frontend/');
                $uploadDir = 'web/img/';
                if (!file_exists($basePath . 'web/img')) {
                    mkdir($basePath . 'web/img', 0777, true);
                }
                if ($model->img != "") {
                    if (\file_exists($basePath . $uploadDir . $model->img)) {
                        unlink($basePath . $uploadDir . $model->img);
                    }
                }
                $nama_ = substr($photo->name, 0, 20);
                $namaFile =   "img_" . str_replace(" ", "", $nama_) . "_". $timeFile;
                $saved = $photo->saveAs($basePath . $uploadDir . $namaFile  . '.' . $photo->extension);
                if (!$saved) {
                    die();
                }
                $model->img = $namaFile.'.'.$photo->extension;
            }

            $model->save(false);

            return $this->redirect(['site/index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
