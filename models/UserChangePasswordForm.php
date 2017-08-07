<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * ContactForm is the model behind the contact form.
 */
class UserChangePasswordForm extends Model
{
    public $new_password;
    public $confirm_password;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['new_password', 'confirm_password'], 'required'],
            [['confirm_password'], 'validatePassword'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'new_password' => 'New Password',
            'confirm_password' => 'New Password confirm',
        ];
    }

    public function validatePassword(){
        if($this->new_password != $this->confirm_password){
            $this->addError('confirm_password', 'New Password not recognized with Confirm password input field');
        }
    }


    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */



    public function changePassword()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        if ($this->validate()) {
            $user->setPwd($this->new_password);
            $user->save();

            Yii::$app->mailer->compose()
                ->setTo($user->email)
                ->setSubject('Changed Password')
                ->setTextBody('You, '.$user->username.' changed password in solid.dev!')
                ->send();
            return true;
        }
        return false;
    }
}
