<?php

namespace app\controllers;

use app\models\News;
use app\models\NewsSearch;
use app\models\User;
use Yii;
use yii\base\Action;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['manager'],
                        'matchCallback' => function ($rule, $action) {
                            /** @var Action $action */
                            //Yii::info($action->id);
                            if ($action->id == 'update' || $action->id == 'delete') {
                                /** @var News $news */
                                $news = News::find()->where(['id' => Yii::$app->request->get('id')])->one();
                                if (!$news) {
                                    return false;
                                }
                                return Yii::$app->user->id == $news->user_id;
                            }
                            return true;
                        },
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();
        $model->published = true;
        $model->deleted = 0;
        $model->user_id = Yii::$app->user->id;
        //$model->create_date = date('Y-m-d H:i:s'); // 2017-07-28 00:00:00
        //$model->update_date = date('Y-m-d H:i:s'); // 2017-07-28 00:00:00

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // where notification true
            $email = User::find()->select('email')->where(['notification' => true])->column(); //where(['notification' => true])
            //$mail = $mail->setTo($email);
            foreach ($email as $email_addres){
                Yii::$app->mailer->compose()
                    ->setFrom('noreply@solid.dev')
                    ->setTo($email_addres)
                    ->setSubject('Новые новости на solid.dev')
                    ->setHtmlBody('<b>На сайте solid.dev новые поступления новостей!<br> Посмотереть: <a href="' . Url::to(['site/news', 'id' => $model->id], true) . '">' . $model->title . '</a></b>')
                    ->send();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            //Yii::info($model->getErrors());
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //$model->update_date = date('Y-m-d H:i:s'); // 2017-07-28 00:00:00

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
