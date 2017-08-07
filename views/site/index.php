<?php
use yii\widgets\ListView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/** @var \yii\db\ActiveQuery $news */
/** @var \yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Новостной портал';

?>

<div class="site-index">

    <div class="jumbotron">
        <h1>Новостной портал</h1>

        <p class="lead">Все что нужно, для Вас.</p>

        <!--        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>-->
    </div>

    <div class="body-content">

        <div class="row">
            <?= ListView::widget([
                'itemView' => '_news',
                'summary' => '',
                'dataProvider' => $dataProvider,
            ]) ?>
            Показать по
            <a href="<?=Url::current(['per-page'=>5])?>">5</a>
            <a href="<?=Url::current(['per-page'=>10])?>">10</a>
            <a href="<?=Url::current(['per-page'=>20])?>">20</a>
            новостей
        </div>
    </div>

</div>