<?php
use yii\helpers\Url;
/* @var $model object */
/* @var $author object */
$this->title = $model->title;
?>
<header id="header">
    <a href="#" class="logo"><span onclick="window.location.replace('<?=URL::to('/raffle/index')?>');">Конкурсы / </span><?=$model->code?></a>
    <p class="icons"><?=date('m.d.Y', $model->created_at)?></p>
</header>
<section>
    <header class="main">
        <h1><?=$model->title?></h1>
    </header>
    <span class="image main"><img src="/app/media/src/raffle/pic11.jpg" alt=""></span>
    <time class="published" datetime="2015-11-01">01.01.21 - 05.01.21</time></br></br>
    <a href="<?=URL::to('/profile').'/'.$author->code?>" class="button">Автор: <?=$author->username?></span></a>
    </br></br>
    <p><?=$model->description?></p>
</section>
