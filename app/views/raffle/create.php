<?php

use yii\helpers\Html;

/* @var $model object */

$this->title = 'Добавление конкурса';
?>
    <header id="header">
        <h2><a href="index.html" class="logo"><?= Html::encode($this->title) ?></a></h2>
    </header>

    <section id="banner">
        <div class="content">
            <?= $this->render('_form', [
                'model' => $model,
                'but_title' => 'Добавить',
            ]) ?>
        </div>
    </section>
