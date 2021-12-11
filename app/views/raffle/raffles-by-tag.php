<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $tag array */
/* @var $Raffles array */

$this->title = Yii::t('app', 'Raffles with the tag') . ': ' . $tag;
?>

<header id="header">
    <a href="#" class="logo"><?= Yii::t('app', 'Raffles') ?> / <?= Yii::t('app', 'Tag') ?>: <?= $tag ?></a>
</header>

<section id="banner">
    <div class="content">

        <h1><?= Html::encode($this->title) ?></h1>

        <?php foreach ($Raffles as $raffle) { ?>
            <div class="box">
                <article class="post">
                    <header>
                        <div class="title">
                            <h2>
                                <a href="<?= Url::to('/show/') . $raffle['raffle_code'] ?>">
                                    <?= $raffle['raffle_title'] ?>
                                </a>
                            </h2>
                        </div>

                        <div class="meta">
                            <time class="published" datetime="2015-11-01">
                                <?= date('j F, Y', $raffle['raffle_created_at']) ?>
                            </time>
                        </div>
                        <div class="meta">
                            <?= Yii::t('app', 'Author') ?>:
                            <a href="<?= Url::to('/profile/') . $raffle['user_code'] ?>" class="author">
                                <?= $raffle['username'] ?>
                            </a>
                        </div>
                    </header>

                    <p><?= $raffle['raffle_short_description'] ?></p>
                    <footer>
                        <ul class="actions">
                            <li>
                                <a href="<?= Url::to('/show/') . $raffle['raffle_code'] ?>" class="button large">
                                    <?= Yii::t('app', 'More details') ?>...
                                </a>
                            </li>
                        </ul>
                    </footer>
                </article>
            </div>
        <?php } ?>
    </div>
</section>

