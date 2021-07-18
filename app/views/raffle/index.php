<?php

/* @var $this yii\web\View */
/* @var $Users array */
/* @var $Raffles array */

$this->title = 'Конкурсы';
use yii\helpers\Html;
use yii\helpers\URL;
?>

<header id="header">
    <a href="#" class="logo">Конкурсы / Все</a>
    <ul class="icons">
        <li><a href="#" class="icon solid fa-search" title="Поиск"><span class="label">Поиск</span></a></li>
        <li><a href="#" class="icon solid fa-sort" title="Фильтр"><span class="label">Фильтр</span></a></li>
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
                        <h2><a href="<?=URL::to('/show/').$raffle['raffle_code']?>"><?=$raffle['raffle_title']?></a></h2>
                    </div>

                    <div class="meta">
                        <time class="published" datetime="2015-11-01"><?=date('j F, Y', $raffle['raffle_created_at'])?></time>
                    </div>
                </header>

                <p><?=$raffle['raffle_short_description']?></p>
                <footer>
                    <ul class="actions">
                        <li>
                            <a href="<?=URL::to('/show/').$raffle['raffle_code']?>" class="button">Подробнее...</a>
                        </li>
                        <li>
                            <?=Html::a('Автор: '.$raffle['username'], URL::to('/profile').'/'.$raffle['user_code'], ['class' => 'button',])?>
                        </li>
                    </ul>
                </footer>
            </article>
        </div>
    <?php } ?>
    </div>
</section>

