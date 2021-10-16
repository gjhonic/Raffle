<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $RafflesApproved \app\models\db\Raffle */
/* @var $RafflesChecked \app\models\db\Raffle */
/* @var $RafflesNotApproved \app\models\db\Raffle */
/* @var $user \app\models\db\User */

?>
<div>
    <div style="overflow-x: auto; display:flex; justify-content: space-between;">
            <a class="button" style="display: inline-block; margin-right: 10px; width: 23%; min-width: 220px" onclick="showApproved()" id="button-approved">Опубликованные</a>

            <a class="button" style="display: inline-block; margin-right: 10px; width: 23%; min-width: 180px" onclick="showCheked()" id="button-checked">На модерации</a>

            <a class="button" style="display: inline-block; margin-right: 10px; width: 23%; min-width: 150px" onclick="showNotApproved()" id="button-not-approved">Запрещенные</a>

            <a class="button" style="display: inline-block; margin-right: 10px; width: 23%; min-width: 180px" href="/raffle/list/<?=$user->code?>">Архив конкурсов</a>
    </div>
    <p>
        <h1 id="head-type-raffle"></h1>
    </p>
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
                            <li><a href="<?=URL::to('/show/').$raffle->code?>" class="button large">Подробнее...</a></li>
                        </ul>
                    </article>
                <?php } ?>
            </div>
            <div>
                <h4 align="center"><a class="button" style="display: inline-block; margin-right: 10px; width: 23%; min-width: 180px" href="/raffle/list/<?=$user->code?>">Архив конкурсов</a></h4>
            </div>
            <?php }else{ ?>
                <article>
                    <p>Таких конкурсов нет</p>
                </article>
            <?php } ?>
    </div>

    <div id="raffle-checked">
        <?php if($RafflesChecked) { ?>
            <div class="posts">
                <?php foreach ($RafflesChecked as $raffle){ ?>
                    <article>
                        <a href="#" class="image"><img src="images/pic01.jpg" alt="" /></a>
                        <div class="image fit"><img src="/app/media/src/raffle/pic11.jpg" alt=""></div>
                        <h3><?=$raffle->title?></h3>
                        <p><?=$raffle->short_description?></p>
                        <ul class="actions">
                            <li><a href="<?=URL::to('/show/').$raffle->code?>" class="button large">Подробнее...</a></li>
                        </ul>
                    </article>
                <?php } ?>
            </div>
            <div>
                <h4 align="center"><a class="button" style="display: inline-block; margin-right: 10px; width: 23%; min-width: 180px" href="/raffle/list/<?=$user->code?>">Архив конкурсов</a></h4>
            </div>
        <?php }else{ ?>
            <article>
                <p>Таких конкурсов нет</p>
            </article>
        <?php } ?>
    </div>

    <div id="raffle-not-approved">
        <?php if($RafflesNotApproved) { ?>
            <div class="posts">
                <?php foreach ($RafflesNotApproved as $raffle){ ?>
                    <article>
                        <a href="#" class="image"><img src="images/pic01.jpg" alt="" /></a>
                        <div class="image fit"><img src="/app/media/src/raffle/pic11.jpg" alt=""></div>
                        <h3><?=$raffle->title?></h3>
                        <p><?=$raffle->short_description?></p>
                        <ul class="actions">
                            <li><a href="<?=URL::to('/show/').$raffle->code?>" class="button large">Подробнее...</a></li>
                        </ul>
                    </article>
                <?php } ?>
            </div>
            <div>
                <h4 align="center"><a class="button" style="display: inline-block; margin-right: 10px; width: 23%; min-width: 180px" href="/raffle/list/<?=$user->code?>">Архив конкурсов</a></h4>
            </div>
        <?php }else{ ?>
            <article>
                <p>Таких конкурсов нет</p>
            </article>
        <?php } ?>
    </div>
</div>

<script>
    function showApproved(){
        document.getElementById('head-type-raffle').innerHTML = 'Опубликованные';

        document.getElementById('button-approved').className = 'button primary';
        document.getElementById('button-checked').className = 'button';
        document.getElementById('button-not-approved').className = 'button';

        document.getElementById('raffle-approved').style.display = "block";
        document.getElementById('raffle-checked').style.display = "none";
        document.getElementById('raffle-not-approved').style.display = "none";

    }


    function showCheked(){
        document.getElementById('head-type-raffle').innerHTML = 'На модерации';

        document.getElementById('button-approved').className = 'button';
        document.getElementById('button-checked').className = 'button primary';
        document.getElementById('button-not-approved').className = 'button';

        document.getElementById('raffle-approved').style.display = "none";
        document.getElementById('raffle-checked').style.display = "block";
        document.getElementById('raffle-not-approved').style.display = "none";
    }

    function showNotApproved(){
        document.getElementById('head-type-raffle').innerHTML = 'Запрещенные';

        document.getElementById('button-approved').className = 'button';
        document.getElementById('button-checked').className = 'button';
        document.getElementById('button-not-approved').className = 'button primary';

        document.getElementById('raffle-approved').style.display = "none";
        document.getElementById('raffle-checked').style.display = "none";
        document.getElementById('raffle-not-approved').style.display = "block";
    }

    showApproved();
</script>