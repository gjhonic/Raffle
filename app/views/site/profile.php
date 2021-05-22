<?php

/* @var $user object */

use yii\helpers\Html;
use yii\helpers\URL;

$this->title = 'Профиль '.$user->username;

?>

    <header id="header">
        <a href="#" class="logo">profile / <?=$user->code?></a>
        <ul class="icons">
            <li><a href="#" class="icon brands fa-vk"><span class="label">Twitter</span></a></li>
            <li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
            <li><a href="#" class="icon brands fa-instagram"><span class="label">Snapchat</span></a></li>
            <li><a href="#" class="icon brands fa-discord"><span class="label">Instagram</span></a></li>
            <li><a href="#" class="icon brands fa-youtube"><span class="label">Medium</span></a></li>
        </ul>
    </header>

    <section id="banner">
        <div class="content">
            <header>
                <h1>
                    <?php if(($hello_message = $user->getHelloMessage()) !== null) { ?>
                        <?=$hello_message?>
                    <?php }else{ ?>
                        Привет я, <?=$user->surname." ".$user->name?>
                    <?php } ?>
                </h1>
                <p></p>
            </header>
            <p>
                <?php if(($about_message = $user->getAboutMessage()) !== null){ ?>
                    <?=$about_message?>
                <?php }else{ ?>
                    Я просто веселый человег!)
                <?php }?>
            </p>
        </div>
        <span class="image object">
            <?php if($user->existAva()){ ?>
                <img src="images/pic10.jpg" alt="" />
            <?php }else{ ?>
                <img src="/app/media/avatars/default_ava.png" alt="" />
            <?php } ?>
        </span>
    </section>

<section>
    <header class="major">
        <h2>Конкурсы</h2>
    </header>
    <div class="posts">
        <?php foreach ($Raffles as $raffle){ ?>
            <article>
                <a href="#" class="image"><img src="images/pic01.jpg" alt="" /></a>
                <h3><?=$raffle->title?></h3>
                <p><?=$raffle->short_description?></p>
                <ul class="actions">
                    <li><a href="<?=URL::to('/show/').$raffle->code?>" class="button large">Подробнее...</a></li>
                </ul>
            </article>
        <?php } ?>
    </div>
</section>

<section id="banner">
    <div class="content">
    <?php if($Raffles != null){ ?>
        <ul class="pagination">
            <li><span class="button disabled">Prev</span></li>
            <li><a href="#" class="page active">1</a></li>
            <li><a href="#" class="page">2</a></li>
            <li><a href="#" class="page">3</a></li>
            <li><span>…</span></li>
            <li><a href="#" class="page">8</a></li>
            <li><a href="#" class="page">9</a></li>
            <li><a href="#" class="page">10</a></li>
            <li><a href="#" class="button">Next</a></li>
        </ul>
    <?php } ?>
    </div>
</section>