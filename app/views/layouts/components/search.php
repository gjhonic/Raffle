<?php

use yii\helpers\Url;
use yii\helpers\Html;

$currentQuery = Yii::$app->request->get('q');
?>

<form method="get" action="<?= Url::to('/search') ?>">
    <?php if ($currentQuery !== null) { ?>
        <input type="text" name="q" id="input-search-by-site"
               placeholder="<?= Yii::t('app', "You are looking for") ?>: <?= Html::encode($currentQuery) ?>"/>
    <?php } else { ?>
        <input type="text" name="q" id="input-search-by-site" placeholder="<?= Yii::t('app', "Search") ?>"/>
    <?php } ?>
</form>