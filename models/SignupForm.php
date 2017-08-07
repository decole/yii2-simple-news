<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class SignupForm extends Model
{
    public $username;
    public $password;
    public $email;
    public $notification;
    /**
     * @return array the validation rules.
     */
    public function rules()
            {
        return [
            // username and password are both required
            [['username', 'password', 'email', 'notification'], 'required'],
            [['password'], 'string', 'min'=>6],
            [['username'], 'string'],
            ['email', 'email'],
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function register()
    {
        if ($this->validate()) {
            $user = new User;
            $user->username = $this->username;
            $user->pwd = $this->password;
            $user->email = $this->email;
            $user->notification = $this->notification;
            $user->email_confirm = Yii::$app->security->generateRandomString();

            if($user->save()){

                // TODO:  отправить письмо
                Yii::$app->mailer->compose('mail-verify', [
                    'user' => $user
                ])
                    ->setFrom('noreply@solid.dev')
                    ->setTo($user->email)
                    ->setSubject('Подтверждение почты для solid.dev')
//                    ->setHtmlBody('<b>Пожалуйста перейдите по ссылке для подтвеждения почты! <a href="'.Url::to(['site/verify-email', 'token' => $user->email_confirm], true).'">Подтвердить</a></b>')
                    ->send();

                $auth = Yii::$app->authManager;
                $role = $auth->getRole('user');
                $auth->assign($role, $user->id);

                Yii::$app->user->login($user);
                return true;
            }
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
