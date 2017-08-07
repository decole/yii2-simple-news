<?php

/* @var User $user */
use app\models\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Verification Email';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if($user){?>
    <p>Hey! <?=$user->username?></p>
    <p>Verify email is Ok!</p>
<?php }else { ?>
    <p>Verify email is not Ok! You shure it was registred later?</p>
<?php } ?>
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>




</div>
