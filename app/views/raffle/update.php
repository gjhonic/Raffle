<?php

use yii\helpers\Url;

/* @var $model object */

$this->title = Yii::t('app', 'Editing a raffles') . ' ' . $model->title;
?>
<header id="header">
    <h2>
        <?= Yii::t('app', 'Editing a raffles') ?>
        <a href="<?= Url::to('/show/') . $model->code ?>" class="logo">
            <i><?= $model->title ?></i>
        </a>
    </h2>
</header>

<section id="banner">
    <div class="content">
        <?= $this->render('update_form', [
            'model' => $model,
        ]) ?>
    </div>
</section>
