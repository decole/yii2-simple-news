<?php
/* @var $this yii\web\View */
/* @var \app\models\User $user */
/* @var \app\models\UserChangePasswordForm $model */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Profile Change Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Profile user <?=$user->username?></h1>

<?php $form = ActiveForm::begin([
    'id' => 'profile-form',
    'layout' => 'horizontal',
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-1 control-label'],
    ],
]); ?>

<?= $form->field($model, 'new_password')->passwordInput(['autofocus' => true])->label("New Password") ?>

<?= $form->field($model, 'confirm_password')->passwordInput()->label("Confirm New Password") ?>


    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Edit Password', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>