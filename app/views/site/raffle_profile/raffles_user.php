<?php

use yii\helpers\Url;

/* @var $RafflesApproved \app\models\db\Raffle */
/* @var $user \app\models\db\User */

?>
<div>
    <h1 id="head-type-raffle"><?=Yii::t('app', 'Raffles')?></h1>

    <div id="raffle-approved">
        <?php if($RafflesApproved) { ?>
            <div class="posts">
                <?php foreach ($RafflesApproved as $raffle){ ?>
                    <article>
                        <a href="#" class="image"><img src="images/pic01.jpg" alt="" /></a>
                        <div class="image fit"><img src="/app/media/src/raffle/pic11.jpg" alt=""></div>
                        <h3><?=$raffle->title?></h3>
                        <p><?=$raffle->short_description?></p>
                        <ul class="actions">
                            <li><a href="<?=URL::to('/show/').$raffle->code?>" class="button large"><?=Yii::t('app', 'More details')?>...</a></li>
                        </ul>
                    </article>
                <?php } ?>
            </div>
            <div>
                <h4 align="center"><a class="button" style="display: inline-block; margin-right: 10px; width: 23%; min-width: 180px" href="/raffle/list/<?=$user->code?>"><?=Yii::t('app', 'Archive of raffles')?></a></h4>
            </div>
        <?php }else{ ?>
            <article>
                <p><?=Yii::t('app', 'No raffles')?></p>
            </article>
        <?php } ?>
    </div>
</div>

