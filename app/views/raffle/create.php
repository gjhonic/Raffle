<?php

use yii\helpers\Html;

/* @var $model object */

$this->title = Yii::t('app', 'Creation of a raffle');
?>

<header id="header">
    <h2>
        <a href="" class="logo">
            <?= Html::encode($this->title) ?>
        </a>
    </h2>

</header>

<section id="banner">
    <div class="content">
        <?= $this->render('create_form', [
            'model' => $model,
            'but_title' => Yii::t('app', 'Create'),
        ]) ?>
    </div>
</section>
