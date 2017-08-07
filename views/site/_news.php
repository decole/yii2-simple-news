<?php
use yii\helpers\Url;

/** @var \app\models\News $model */
?>
<div class="col-lg-12">
    <h2><?=$model->title ?></h2>

    <p><?= $model->preview_text ?></p>
    <p>Дата публикации: <?=Yii::$app->formatter->asDate($model->create_date, 'php:d.m.Y')?></p>
    <p><a class="btn btn-default"
          href="<?= Url::to(['site/news', 'id' => $model->id]) ?>">Подробнее &raquo;</a></p>
</div>