<?php
use app\models\User;
use yii\helpers\Url;

/** @var User $user */
?>

<b>Пожалуйста перейдите по ссылке для подтвеждения почты! <a href="<?= Url::to(['site/verify-email', 'token' => $user->email_confirm], true)?>">Подтвердить</a></b>