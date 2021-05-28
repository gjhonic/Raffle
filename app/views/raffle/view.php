<?php
/* @var $user object */
$this->title = $model->title;
?>
<header id="header">
    <a href="index.html" class="logo"><strong>Show/<?=$model->code?></strong></a>
    <p class="icons"><?=date('m.d.Y', $model->created_at)?></p>
</header>
<section>
    <header class="main">
        <h1><?=$model->title?></h1>
    </header>
    <span class="image main"><img src="/app/media/src/raffle/pic11.jpg" alt=""></span>
    <time class="published" datetime="2015-11-01">01.01.21 - 05.01.21</time></br></br>
    <a href="#" class="button"><span class="name">Jane Doe</span></a>
    </br></br><p><?=$model->description?></p>
</section>
