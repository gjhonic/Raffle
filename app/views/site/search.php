<?php

/* @var $Raffles array */
/* @var $Users array */
/* @var $Tags array */
/* @var $query string */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t("app", "Search by request") . ": " . $query;

?>

<section id="banner">
    <div class="content">
        <header>
            <h1><?= Html::encode($this->title) ?></h1>
        </header>
    </div>
</section>

<div>
    <div style="overflow-x: auto; display:flex; justify-content: space-between;">
        <a class="button" style="display: inline-block; margin-right: 10px; width: 32%; min-width: 220px" onclick="showRaffles()" id="button-raffles"><?=Yii::t('app', 'Raffles')?></a>

        <a class="button" style="display: inline-block; margin-right: 10px; width: 32%; min-width: 180px" onclick="showUsers()" id="button-users"><?=Yii::t('app', 'Users')?></a>

        <a class="button" style="display: inline-block; margin-right: 10px; width: 32%; min-width: 150px" onclick="showTags()" id="button-tags"><?=Yii::t('app', 'Tags')?></a>

    </div>
    <p>
    <h1 id="head-content"></h1>
    </p>
    <div id="content-raffles">
        <?php if($Raffles) { ?>
            <?php foreach ($Raffles as $raffle){ ?>
                <div class="box">
                    <article class="post">
                        <header>
                            <div class="title">
                                <h2><a href="<?=Url::to('/show/').$raffle['raffle_code']?>"><?=$raffle['raffle_title']?></a></h2>
                            </div>

                            <div class="meta">
                                <time class="published" datetime="2015-11-01"><?=date('j F, Y', $raffle['raffle_created_at'])?></time>
                            </div>
                        </header>

                        <p><?=$raffle['raffle_short_description']?></p>
                        <footer>
                            <ul class="actions">
                                <li>
                                    <a href="<?=Url::to('/show/').$raffle['raffle_code']?>" class="button"><?=Yii::t("app", "More details")?>...</a>
                                </li>
                                <li>
                                    <?=Html::a('Автор: '.$raffle['username'], Url::to('/profile').'/'.$raffle['user_code'], ['class' => 'button',])?>
                                </li>
                            </ul>
                        </footer>
                    </article>
                </div>
            <?php } ?>
        <?php }else{ ?>
            <article>
                <p><?=Yii::t("app", "Raffles not found")?></p>
            </article>
        <?php } ?>
    </div>

    <div id="content-users">
        <?php if($Users) { ?>
            <div class="posts">
                <?php foreach ($Users as $user){ ?>
                    <article>
                        <div class="image fit"><img src="/app/media/src/raffle/pic11.jpg" alt=""></div>
                        <h3><a href="/profile/<?=$user->code?>"><?=$user->username?></a></h3>
                    </article>
                <?php } ?>
            </div>
        <?php }else{ ?>
            <article>
                <p><?=Yii::t("app", "Users not found")?></p>
            </article>
        <?php } ?>
    </div>

    <div id="content-tags">
        <?php if($Tags) { ?>
            <div class="posts">
                <?php foreach ($Tags as $tag){ ?>
                    <article>
                        <a class="button large" href="<?=Url::to('/raffle-by-tag/').$tag['title']?>" title="Показать конкурсы с тегом: <?=$tag['title']?>"><?=$tag['title']?></a>
                    </article>
                <?php } ?>
            </div>
        <?php }else{ ?>
            <article>
                <p><?=Yii::t("app", "Tags not found")?></p>
            </article>
        <?php } ?>
    </div>
</div>

<script>
    function showRaffles(){
        $("#head-content").html("<?=Yii::t('app', 'Raffles')?>");
        $("#button-raffles").removeClass().addClass('button primary');
        $("#button-users").removeClass().addClass('button');
        $("#button-tags").removeClass().addClass('button');
        $("#content-raffles").show();
        $("#content-users").hide();
        $("#content-tags").hide();
    }

    function showUsers(){
        $("#head-content").html("<?=Yii::t('app', 'Users')?>");
        $("#button-raffles").removeClass().addClass('button');
        $("#button-users").removeClass().addClass('button primary');
        $("#button-tags").removeClass().addClass('button');
        $("#content-raffles").hide();
        $("#content-users").show();
        $("#content-tags").hide();
    }

    function showTags(){
        $("#head-content").html("<?=Yii::t('app', 'Tags')?>");
        $("#button-raffles").removeClass().addClass('button');
        $("#button-users").removeClass().addClass('button');
        $("#button-tags").removeClass().addClass('button primary');
        $("#content-raffles").hide();
        $("#content-users").hide();
        $("#content-tags").show();
    }
    showRaffles();
</script>

