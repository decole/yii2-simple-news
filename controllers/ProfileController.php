<?php

namespace app\controllers;


use app\models\User;
use app\models\UserChangePasswordForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;


class ProfileController extends Controller
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
                        'roles' => ['user'],
                        'allow' => true,
                    ],
                ],
            ],

        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        $user->scenario = User::SCENARIO_PROFILE;
        //$requester = Yii::$app->request->post('User');
        if (Yii::$app->request->post()) {
            //$user->notification = isset($requester['notification'])? $requester['notification'] : null;
            $user->load(Yii::$app->request->post());
            $user->save();
            //Yii::info($user->getErrors());
        }
        return $this->render('index', [
            'user' => $user,
        ]);
    }

    public function actionRepassword()
    {
        $model = new UserChangePasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

}
