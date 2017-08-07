<?php
/* @var $this yii\web\View */
/* @var \app\models\User $user */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Profile Properties';
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

<?= $form->field($user, 'notification')->checkbox([
    'label' => 'notification to email?',
    'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
]) ?>



    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Edit Profile', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>