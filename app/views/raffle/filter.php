<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $Users array */
/* @var $Raffles array */

$this->title = Yii::t('app', 'Raffles');
?>

<header id="header">
    <a href="#" class="logo"><?= Yii::t('app', 'Raffles') ?> / <?= Yii::t('app', 'Filter') ?></a>
</header>

<section id="banner">
    <div class="content">

        <h1><?= Html::encode($this->title) ?></h1>
    </div>
</section>