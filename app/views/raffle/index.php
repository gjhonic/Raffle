<?php

/* @var $this yii\web\View */

$this->title = 'Конкурсы';
use yii\helpers\Html;
use yii\helpers\URL;
?>

<header id="header">
    <a href="#" class="logo">Конкурсы / все</a>
    <ul class="icons">
        <li><a href="#" class="icon brands fa-searchengin"><span class="label">Поиск</span></a></li>
        <li><a href="#" class="icon brands fa-sort"><span class="label">Snapchat</span></a></li>
        <li><a href="#" class="icon brands fa-discord"><span class="label">Instagram</span></a></li>
        <li><a href="#" class="icon brands fa-youtube"><span class="label">Medium</span></a></li>
    </ul>
</header>

<section id="banner">
    <div class="content">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php foreach ($Raffles as $raffle){ ?>
        <div class="box">
        <article class="post">
            <header>
                <div class="title">
                    <h2><a href="single.html"><?=$raffle->title?></a></h2>
                </div>
                <div class="meta">
                    <time class="published" datetime="2015-11-01"><?=date('j F, Y', $raffle->updated_at)?></time>
                    <a href="#" class="author"><span class="name"><?=$Users[$raffle->user_id]?></span><img src="images/avatar.jpg" alt=""></a>
                </div>
            </header>
            <p><?=$raffle->short_description?></p>
            <footer>
                <ul class="actions">
                    <li><a href="<?=URL::to('/show/').$raffle->code?>" class="button large">Подробнее...</a></li>
                </ul>
            </footer>
        </article>
        </div>

    <?php } ?>
    </div>
</section>

