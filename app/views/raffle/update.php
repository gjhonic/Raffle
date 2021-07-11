<?php

use yii\helpers\Html;

/* @var $model object */

$this->title = 'Редактирование конкурса '.$model->title;
?>
<header id="header">
    <h2><a href="index.html" class="logo"><?= Html::encode($this->title) ?></a></h2>
</header>

<section id="banner">
    <div class="content">
        <?= $this->render('update_form', [
            'model' => $model,
            'but_title' => 'Добавить',
        ]) ?>
    </div>
</section>
