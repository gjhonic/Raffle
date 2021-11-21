<?php

use yii\helpers\Url;

$lang = Yii::$app->language;
$currentUrl = mb_substr(Url::to(), 4);

$langEnActive = ($lang == "en") ? 'button primary' : "button";
$langRuActive = ($lang == "ru") ? 'button primary' : "button";
?>

<div class="change-lang">
    <a href="/en/<?=$currentUrl?>" class="<?=$langEnActive?>">en</a>
    <a href="/ru/<?=$currentUrl?>" class="<?=$langRuActive?>">ru</a>
</div>