<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/** @var \app\models\News $news */

$this->title = 'News';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $news->title;
?>

<div class="site-contact">
    <h1><?= Html::encode($news->title) ?></h1>
    <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= $news->detail_text ?>
    </div>
    </div>


</div>
