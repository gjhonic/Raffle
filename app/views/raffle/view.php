<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\widgets\RaffleStatusWidget;

/* @var $raffle array */
/* @var $Tags array */

$this->title = $raffle['raffle_title'];
?>

<header id="header">
    <a href="#" class="logo"><span onclick="window.location.replace('<?=URL::to('/raffle/index')?>');">Конкурсы / </span><?=$raffle['raffle_code']?></a>
    <p class="icons"><?=date('m.d.Y', $raffle['raffle_created_at'])?></p>
</header>
<section>
    <header class="main">
        <h1>
            <?= Html::encode($this->title) ?>
            <?php if(Yii::$app->user->identity->getId() == $raffle['user_id']){ ?>
                <?=RaffleStatusWidget::getIcon($raffle['raffle_status_id'])?>
            <?php } ?>
        </h1>
    </header>
    <span class="image main"><img src="/app/media/src/raffle/pic11.jpg" alt=""></span>
    <time class="published">
        <?php
            if($raffle['raffle_date_begin']!== null){
                echo $raffle['raffle_date_begin'];
            }else{
                echo "???";
            }
        ?>
            -
        <?php
            if($raffle['raffle_date_end']!== null){
                echo $raffle['raffle_date_end'];
            }else{
                echo "???";
            }
        ?>
    </time>

    <div class="box-tags">
        <h4>Теги: </h4>
        <div style="overflow-x: auto; display:flex;">
            <?php foreach ($Tags as $tag) { ?>
                <a class="button small" href="<?=Url::to('/raffle-by-tag/').$tag['tag_title']?>" style="margin-right: 10px;"><?=$tag['tag_title']?></a>
            <?php } ?>
        </div>
    </div>

    <p><?=$raffle['raffle_description']?></p>

    <p>
        <div style="overflow-x: auto; display:flex;">
            <?=Html::a('Автор:'.$raffle['username'], URL::to('/profile').'/'.$raffle['user_code'], ['class' => 'button', 'style'=>'margin-right: 10px'])?>

            <?php if($raffle['user_id'] == Yii::$app->user->identity->getId()) { ?>
                <?=Html::a('Редактировать', URL::to('/raffle/update/').$raffle['raffle_code'], ['class' => 'button', 'style'=>'margin-right: 10px'])?>
                <span class="button" id="button-show-note" onclick="showNote()">Показать заметку</span>
                <span class="button" id="button-hide-note" onclick="hideNote()">Скрыть заметку</span>
            <?php } ?>
        </div>
    <p>
    <p>

        <?php if($raffle['user_id'] == Yii::$app->user->identity->getId()) { ?>
            <div id="div-input-note">
                <h3><label for="input-note">
                        Заметка к конкурсу
                        <span id="load-save-note" style="color: grey"></span>
                        <span id="error-save-note" style="color: red"></span>
                    </label>
                </h3>
                <textarea name="" id="input-note" cols="30" rows="10"><?=$raffle['raffle_note']?></textarea><br>
                <span class="button fit" onclick="saveRaffleNote()">Сохранить</span><br>
                <span>Эту заметку видит только автор конкурса</span>

            </div>

            <script>
                function showNote(){
                    $("#div-input-note").show();
                    $("#button-show-note").hide();
                    $("#button-hide-note").show();
                }
                function hideNote(){
                    $("#div-input-note").hide();
                    $("#button-show-note").show();
                    $("#button-hide-note").hide();
                }

                function saveRaffleNote(){
                    let note = $("#input-note").val();
                    let csrfToken = $('meta[name="csrf-token"]').attr("content");
                    $.ajax({
                        url: '/raffle/save-note',
                        type: 'POST',
                        dataType: 'json',
                        data: {raffle_code: '<?=$raffle['raffle_code']?>', note: note, _csrf: csrfToken},
                        success: function(res){
                            let timerId = setInterval(() => addPointForLoading(), 100);
                            setTimeout(() => {clearInterval(timerId); clearLoading();}, 400);
                        },
                        error: function(){
                            let timerId = setInterval(() => addPointForLoading(), 100);
                            setTimeout(() => {clearInterval(timerId); errorSaveNote();}, 400);
                        }
                    });
                }

                function addPointForLoading(){
                    $("#load-save-note").html($("#load-save-note").html()+' .');
                }
                function clearLoading(){
                    $("#load-save-note").html('');
                }
                function errorSaveNote(){
                    $("#error-save-note").html('Ошибка сохранения');
                }

                hideNote();
            </script>
        <?php } ?>
    </p>
    <br>
</section>