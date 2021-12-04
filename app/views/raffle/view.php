<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\widgets\RaffleStatusWidget;

/* @var $raffle \app\models\base\Raffle */
/* @var $Tags \app\models\base\Tag */

$this->title = $raffle->title
?>

<header id="header">
    <a href="#" class="logo">
        <span onclick="window.location.replace('<?= Url::to('/raffle/index') ?>');">
            <?= Yii::t("app", "Raffles") ?> /
        </span>
        <?= $raffle->code ?>
    </a>
    <p class="icons"><?= date('m.d.Y', $raffle->created_at) ?></p>
</header>
<section>
    <header class="main">
        <h1>
            <?= Html::encode($this->title) ?>
            <?php if (Yii::$app->user->identity->getId() == $raffle->user_id) { ?>
                <?= RaffleStatusWidget::getIcon($raffle->status_id) ?>
            <?php } ?>
        </h1>
    </header>
    <span class="image main"><img src="/app/media/src/raffle/pic11.jpg" alt=""></span>
    <time class="published">
        <?php
        if ($raffle->date_begin !== null) {
            echo $raffle->date_begin;
        } else {
            echo "???";
        }
        ?>
        -
        <?php
        if ($raffle->date_end !== null) {
            echo $raffle->date_end;
        } else {
            echo "???";
        }
        ?>
    </time>

    <div class="box-tags">
        <h4><?= Yii::t("app", "Tags") ?>: </h4>
        <div style="overflow-x: auto; display:flex;">
            <?php foreach ($raffle->tags as $tag) { ?>
                <a class="button small" href="<?= Url::to('/raffle-by-tag/') . $tag->title ?>"
                   style="margin-right: 10px;"><?= $tag->title ?></a>
            <?php } ?>
        </div>
    </div>

    <p><?= $raffle->description ?></p>

    <p>
    <div style="overflow-x: auto; display:flex;">
        <?= Html::a(Yii::t("app", "Author") . ':' . $raffle->user->username, Url::to('/profile') . '/' . $raffle->user->code, ['class' => 'button', 'style' => 'margin-right: 10px']) ?>

        <?php if ($raffle->user_id == Yii::$app->user->identity->getId()) { ?>
            <?= Html::a('Редактировать', Url::to('/raffle/update/') . $raffle->code, ['class' => 'button', 'style' => 'margin-right: 10px']) ?>
            <span class="button" id="button-show-note" onclick="showNote()"><?= Yii::t('app', 'Show note') ?></span>
            <span class="button" id="button-hide-note" onclick="hideNote()"><?= Yii::t('app', 'Hide note') ?></span>
        <?php } ?>
    </div>
    <p>

        <?php if ($raffle->user_id == Yii::$app->user->identity->getId()) { ?>
        <?php
        //TODO Ajax переписать на fetch и вынести в отдельный файл
        ?>
    <div id="div-input-note">
        <h3><label for="input-note">
                Заметка к конкурсу
                <span id="load-save-note" style="color: grey"></span>
                <span id="error-save-note" style="color: red"></span>
            </label>
        </h3>
        <textarea name="" id="input-note" cols="30" rows="10"><?= $raffle->note ?></textarea><br>
        <span class="button fit" onclick="saveRaffleNote()">Сохранить</span><br>
        <span>Эту заметку видит только автор конкурса</span>

    </div>

    <script>
        function showNote() {
            $("#div-input-note").show();
            $("#button-show-note").hide();
            $("#button-hide-note").show();
        }

        function hideNote() {
            $("#div-input-note").hide();
            $("#button-show-note").show();
            $("#button-hide-note").hide();
        }

        function saveRaffleNote() {
            let note = $("#input-note").val();
            let csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                url: '/raffle/save-note',
                type: 'POST',
                dataType: 'json',
                data: {raffle_code: '<?=$raffle->code?>', note: note, _csrf: csrfToken},
                success: function (res) {
                    let timerId = setInterval(() => addPointForLoading(), 100);
                    setTimeout(() => {
                        clearInterval(timerId);
                        clearLoading();
                    }, 400);
                },
                error: function () {
                    let timerId = setInterval(() => addPointForLoading(), 100);
                    setTimeout(() => {
                        clearInterval(timerId);
                        errorSaveNote();
                    }, 400);
                }
            });
        }

        function addPointForLoading() {
            $("#load-save-note").html($("#load-save-note").html() + ' .');
        }

        function clearLoading() {
            $("#load-save-note").html('');
        }

        function errorSaveNote() {
            $("#error-save-note").html('Ошибка сохранения');
        }

        hideNote();
    </script>
    <?php } ?>
    <br>
</section>