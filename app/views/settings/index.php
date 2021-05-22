<?php

/* @var $user object */
/* @var $model object */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\URL;

$this->title = 'Настройка';

?>
<header id="header">
    <a href="" class="logo"><span >Настройки </span>/ Все</a>
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
    </div>
    <span class="image object">
            <?php if($user->existAva()){ ?>
                <img src="images/pic10.jpg" alt="" />
            <?php }else{ ?>
                <a href="" title="Изменить"><img src="/app/media/avatars/default_ava.png" alt="" /></a>
            <?php } ?>
        </span>
</section>