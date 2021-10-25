<?php

/* @var $user object */
/* @var $model object */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Settings');

?>
<header id="header">
    <a href="" class="logo"><span><?=Yii::t('app', 'Settings')?> </span>/ <?=Yii::t('app', 'All')?></a>
</header>

<section id="banner">
    <div class="content">
        <header>
            <h1>
                <?= Html::encode($this->title) ?>
            </h1>
            <p></p>
        </header>
        <p>
            <?= Html::a('Настройка профиля', URL::to('/settings/account'), ['class' => 'button fit']) ?>
        </p>
        <p>
            <?= Html::a('Настройка пароля', URL::to('/settings/password'), ['class' => 'button fit']) ?>
        </p>
        <hr>
        <p>
            <?= Html::a('Написать в поддержку', URL::to('/support'), ['class' => 'button fit']) ?>
        </p>
        <p>
            <?= Html::a('Публичное API', URL::to('/api'), ['class' => 'button fit']) ?>
        </p>
    </div>
    <span class="image object">
            <?php if($user->existAva()){ ?>
                <img src="images/pic10.jpg" alt="" />
            <?php }else{ ?>
                <a href="" title="Изменить"><img src="/app/media/avatars/default_ava.png" alt="" /></a>
            <?php } ?>
        </span>
</section>