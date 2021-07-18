<?php

/* @var $Raffles \app\models\db\Raffle */
/* @var $Users \app\models\db\User */
/* @var $Tags \app\models\db\Tag */
/* @var $query string */

use yii\helpers\Html;
use yii\helpers\URL;

$this->title = 'Поиск по запросу '.$query;

?>

<section id="banner">
    <div class="content">
        <header>
            <h1><?= Html::encode($this->title) ?></h1>
            <p></p>
        </header>
    </div>
</section>

<div>
    <div style="overflow-x: auto; display:flex; justify-content: space-between;">
        <a class="button" style="display: inline-block; margin-right: 10px; width: 32%; min-width: 220px" onclick="showRaffles()" id="button-raffles">Конкурсы</a>

        <a class="button" style="display: inline-block; margin-right: 10px; width: 32%; min-width: 180px" onclick="showUsers()" id="button-users">Пользователи</a>

        <a class="button" style="display: inline-block; margin-right: 10px; width: 32%; min-width: 150px" onclick="showTags()" id="button-tags">Теги</a>

    </div>
    <p>
    <h1 id="head-content"></h1>
    </p>
    <div id="content-raffles">
        <?php if($Raffles) { ?>
            <div class="posts">
                <?php foreach ($Raffles as $raffle){ ?>
                    <article>
                        <a href="#" class="image"><img src="images/pic01.jpg" alt="" /></a>
                        <div class="image fit"><img src="/app/media/src/raffle/pic11.jpg" alt=""></div>
                        <h3><?=$raffle->title?></h3>
                        <p><?=$raffle->short_description?></p>
                        <ul class="actions">
                            <li><a href="<?=URL::to('/show/').$raffle->code?>" class="button large">Подробнее...</a></li>
                        </ul>
                    </article>
                <?php } ?>
            </div>
        <?php }else{ ?>
            <article>
                <p>Конкурсов не нашел</p>
            </article>
        <?php } ?>
    </div>

    <div id="content-users">
        <?php if($Users) { ?>
            <div class="posts">
                <?php foreach ($Users as $user){ ?>
                    <article>
                        <a href="#" class="image"><img src="images/pic01.jpg" alt="" /></a>
                        <div class="image fit"><img src="/app/media/src/raffle/pic11.jpg" alt=""></div>
                        <h3><a href="/profile/<?=$user->code?>"><?=$user->username?></a></h3>
                    </article>
                <?php } ?>
            </div>
        <?php }else{ ?>
            <article>
                <p>Пользователей не нашел</p>
            </article>
        <?php } ?>
    </div>

    <div id="content-tags">
        <?php if($Tags) { ?>
            <div class="posts">
                <?php foreach ($Tags as $tag){ ?>
                    <article>
                        <a class="button large" href="<?=Url::to('/raffle-by-tag/').$tag->title?>" title="Показать конкурсы с тегом: <?=$tag->title?>"><?=$tag->title?></a>
                    </article>
                <?php } ?>
            </div>
        <?php }else{ ?>
            <article>
                <p>Таких тегов нет</p>
            </article>
        <?php } ?>
    </div>
</div>

<script>
    function showRaffles(){
        document.getElementById('head-content').innerHTML = 'Конкурсы';

        document.getElementById('button-raffles').className = 'button primary';
        document.getElementById('button-users').className = 'button';
        document.getElementById('button-tags').className = 'button';

        document.getElementById('content-raffles').style.display = "block";
        document.getElementById('content-users').style.display = "none";
        document.getElementById('content-tags').style.display = "none";

    }


    function showUsers(){
        document.getElementById('head-content').innerHTML = 'Пользователи';

        document.getElementById('button-raffles').className = 'button';
        document.getElementById('button-users').className = 'button primary';
        document.getElementById('button-tags').className = 'button';

        document.getElementById('content-raffles').style.display = "none";
        document.getElementById('content-users').style.display = "block";
        document.getElementById('content-tags').style.display = "none";
    }

    function showTags(){
        document.getElementById('head-content').innerHTML = 'Теги';

        document.getElementById('button-raffles').className = 'button';
        document.getElementById('button-users').className = 'button';
        document.getElementById('button-tags').className = 'button primary';

        document.getElementById('content-raffles').style.display = "none";
        document.getElementById('content-users').style.display = "none";
        document.getElementById('content-tags').style.display = "block";
    }

    showRaffles();
</script>

