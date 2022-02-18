<?php

use app\assets\FrontendAsset;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $Users array */
/* @var $Raffles array */

$this->title = Yii::t('app', 'Popular raffles');

$this->registerJsFile('/media/general/js/load_raffles.js', ['depends' => [FrontendAsset::className()], 'position' => \yii\web\View::POS_END]);
?>

<header id="header">
    <a href="#" class="logo"><?= Yii::t('app', 'Raffles') ?> / <?= Yii::t('app', 'Popular') ?></a>
    <ul class="icons">
        <li>
            <a class="icon solid fa-filter" href="<?=Url::to('raffle/filter')?>" title="<?= Yii::t('app', 'Filter') ?>" style="cursor: pointer">
                <span class="label"><?= Yii::t('app', 'Filter') ?></span>
            </a>
        </li>
    </ul>
</header>

<section id="banner">
    <div class="content">

        <h1><?= Html::encode($this->title) ?></h1>

        <div id="box-raffles">
            <?php foreach ($Raffles as $raffle) { ?>
                <div class="box">
                    <article class="post">
                        <header>
                            <div class="title">
                                <h2>
                                    <a href="<?= Url::to('/show/') . $raffle->code ?>"><?= $raffle->title ?></a>
                                </h2>
                            </div>

                            <div class="meta">
                                <time class="published"><?= $raffle->date_begin ?></time>
                            </div>
                        </header>

                        <p><?= $raffle->short_description ?></p>
                        <footer>
                            <ul class="actions">
                                <li>
                                    <a href="<?= Url::to('show/') . $raffle->code ?>"
                                       class="button"><?= Yii::t('app', 'More details') ?>...</a>
                                </li>
                                <li>
                                    <?= Html::a('Автор: ' . $raffle->user->username, Url::to('/profile') . '/' . $raffle->code, ['class' => 'button',]) ?>
                                </li>
                            </ul>
                        </footer>
                    </article>
                </div>
            <?php } ?>
        </div>
        <p align="center" id="load-head"></p>
        <span id="button-load" class="button fit" onclick="loadPopularRaffles()">Загрузить еще</span>
    </div>
</section>

<script>

</script>
