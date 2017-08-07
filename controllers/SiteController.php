<?php

namespace app\controllers;

use app\models\SignupForm;
use app\models\User;
use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\News;

class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['news'],
                        'roles' => ['user'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['news'],
                        'roles' => ['guest'],
                        'allow' => false,
                    ],
                    [
//                        'actions' => ['logout'],
                        'allow' => true,
//                        'roles' => ['?'],
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
     * @inheritdoc
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
     * @return string
     */
    public function actionIndex()
    {
        $news  = News::find()->where(['published' => 1, 'deleted' => 0]);

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $news,
            'sort' => [
                'attributes' => ['id', 'username', 'email'],
            ],
            'pagination' => [
                //'pageSize' => 2,
            ],
        ]);

        return $this->render('index', [
            'news' => $news,
            'dataProvider' => $dataProvider,
            //'pagination' => $pagination
        ]);
    }


    /**
     * @param $id
     * @return string
     */
    public function actionNews($id){
//        if (Yii::$app->user->isGuest) {
//            return $this->actionLogin();
//        }

        $news = News::find()->where(['id' => $id])->one();
        return $this->render('news', [
            'news' => $news,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Signup action.
     *
     * @return Response|string
     */
    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->goBack();
        }
        $model->notification = true;
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Verify Email Token action.
     *
     * @return Response|string
     */
    public function actionVerifyEmail($token)
    {
        /** @var User|null $user */
        $user = User::find()->where(['email_confirm' => $token])->one();

        if($user && !$user->is_confirm) {
            $user->is_confirm = true;
            $user->email_confirm = null;
            if($user->save()) {
                Yii::$app->user->login($user);
                if($user->password == null){
                    return $this->redirect(['profile/repassword']);
                }

                return $this->render('verify', [
                    'user' => $user
                ]);
            }
        }

        return $this->render('verify', [
            'user' => $user
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

}
