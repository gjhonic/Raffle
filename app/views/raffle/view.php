<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\widgets\RaffleStatusWidget;

/* @var $raffle array */
/* @var $Tags array */

$this->title = $raffle['raffle_title'];
?>

<header id="header">
    <a href="#" class="logo"><span onclick="window.location.replace('<?=URL::to('/raffle/index')?>');">Конкурсы / </span><?=$raffle['raffle_code']?></a>
    <p class="icons"><?=date('m.d.Y', $raffle['raffle_created_at'])?></p>
</header>
<section>
    <header class="main">
        <h1>
            <?= Html::encode($this->title) ?>
            <?php if(Yii::$app->user->identity->getId() == $raffle['user_id']){ ?>
                <?=RaffleStatusWidget::getIcon($raffle['raffle_status_id'])?>
            <?php } ?>
        </h1>
    </header>
    <span class="image main"><img src="/app/media/src/raffle/pic11.jpg" alt=""></span>
    <time class="published">
        <?php
            if($raffle['raffle_date_begin']!== null){
                echo $raffle['raffle_date_begin'];
            }else{
                echo "???";
            }
        ?>
            -
        <?php
            if($raffle['raffle_date_end']!== null){
                echo $raffle['raffle_date_end'];
            }else{
                echo "???";
            }
        ?>
    </time>

    <div class="box-tags">
        <h4>Теги: </h4>
        <?php foreach ($Tags as $tag) { ?>
            <a class="button small" href="<?=Url::to('/raffle-by-tag/').$tag['tag_title']?>"><?=$tag['tag_title']?></a>
        <?php } ?>
    </div>

    <p><?=$raffle['raffle_description']?></p>

    <p>
        <?=Html::a('Автор:'.$raffle['username'], URL::to('/profile').'/'.$raffle['user_code'], ['class' => 'button'])?>

        <?php if($raffle['user_id'] == Yii::$app->user->identity->getId()) {
            echo Html::a('Редактировать', URL::to('/raffle/update/').$raffle['raffle_code'], ['class' => 'button']);
        } ?>
    </p>
    <br>
</section>
