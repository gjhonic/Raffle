<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Settings');

?>
<header id="header">
    <a href="" class="logo"><span><?= Yii::t('app', 'Settings') ?> </span> / <?= Yii::t('app', 'All') ?></a>
</header>

<section id="banner">
    <div class="content">
        <header>
            <h1>
                <?= Html::encode($this->title) ?>
            </h1>
        </header>

        <div class="row">
            <div class="col-6">
                <p>
                    <?= Html::a(Yii::t('app', 'Basic settings'), URL::to('/settings/account'), ['class' => 'button fit']) ?>
                </p>
                <p>
                    <?= Html::a(Yii::t('app', 'Password setting'), URL::to('/settings/password'), ['class' => 'button fit']) ?>
                </p>
                <hr>
                <p>
                    <?= Html::a(Yii::t('app', 'Contact support'), URL::to('/support'), ['class' => 'button fit']) ?>
                </p>
                <p>
                    <?= Html::a(Yii::t('app', 'Public API'), URL::to('/api'), ['class' => 'button fit']) ?>
                </p>
            </div>
            <div class="col-6">

            </div>
        </div>
    </div>
</section>