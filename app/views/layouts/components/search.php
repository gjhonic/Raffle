<?php

use yii\helpers\Url;
?>

<form method="get" action="<?=Url::to('/search')?>">
    <?php if(($current_query = Yii::$app->request->get('q')) !== null) { ?>
        <input type="text" name="q" id="input-search-by-site" placeholder="<?= Yii::t('app', "You are looking for")?>: <?=$current_query?>" />
    <?php } else {?>
        <input type="text" name="q" id="input-search-by-site" placeholder="<?= Yii::t('app', "Search")?>" />
    <?php } ?>
</form>