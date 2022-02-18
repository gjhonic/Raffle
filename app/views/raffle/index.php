<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $Users array */
/* @var $Raffles array */

$this->title = Yii::t('app', 'Raffles');

?>

<header id="header">
    <a href="#" class="logo"><?= Yii::t('app', 'Raffles') ?> / <?= Yii::t('app', 'All') ?></a>
    <ul class="icons">
        <li>
            <a class="icon solid fa-filter" title="<?= Yii::t('app', 'Filter') ?>" style="cursor: pointer">
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
                                    <a href="<?= Url::to('/show/') . $raffle->code ?>"
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
        <span id="button-load" class="button fit" onclick="loadRaffle()">Загрузить еще</span>
    </div>
</section>

<script>
    let page = 1;

    function loadRaffle() {
        let csrfToken = $('meta[name="csrf-token"]').attr("content");
        let filter_date = '<?=Yii::$app->request->get('filter_date')?>';
        let filter_abc = '<?=Yii::$app->request->get('filter_abc')?>';
        let filter_group = '<?=Yii::$app->request->get('filter_group')?>'
        //TODO Юзать Fetch
        $.ajax({
            url: '/raffle/get-raffles-json',
            type: 'GET',
            dataType: 'json',
            data: {
                filter_date: filter_date,
                filter_abc: filter_abc,
                filter_group: filter_group,
                page: page,
                _csrf: csrfToken
            },
            success: function (res) {
                $('#load-head').html('Загрузка');
                let timerId = setInterval(() => addPointForLoading(), 200);
                if (res['data'] == false) {
                    setTimeout(() => {
                        clearInterval(timerId);
                        clearLoading();
                        endRaffles();
                    }, 700);
                    page++;
                } else {
                    setTimeout(() => {
                        clearInterval(timerId);
                        clearLoading();
                        setRaffleFromLoad(res['data']);
                    }, 700);
                }
            },
            error: function () {
                $('#load-head').html('Загрузка');
                let timerId = setInterval(() => addPointForLoading(), 200);
                setTimeout(() => {
                    clearInterval(timerId);
                    errorLoadRaffles();
                }, 700);
            }
        });
    }

    function setRaffleFromLoad(raffles) {
        for (let i = 0; i < 10; i++) {
            let raffle_title = raffles[i].raffle_title;
            let raffle_code = raffles[i].raffle_code;
            let raffle_short_description = raffles[i].raffle_short_description;
            let raffle_created_at = raffles[i].raffle_created_at;
            let d = new Date(raffle_created_at * 1000);
            raffle_created_at = d.getDate() + '.' + (d.getMonth() + 1) + '.' + d.getFullYear();
            let username = raffles[i].username;
            let user_code = raffles[i].user_code;

            $("#box-raffles").append("<div class='box'><article class='post'>" +
                "<header> <div class='title'><h2>" +
                "<a href='/show/" + raffle_code + "'>" + raffle_title + "</a><h2></div>" +
                "<div class='meta'><time class='published'>" + raffle_created_at + "</time></div></header>" +
                "<p>" + raffle_short_description + "</p>" +
                "<footer><ul class='actions'><li><a href='/show/" + raffle_code + "' class='button'>Подробнее...</a></li>" +
                "<li><a href='/profile/" + user_code + "' class='button'>Автор: " + username + "</a></li></ul></footer></article></div>"
            );
        }
    }

    function addPointForLoading() {
        $("#load-head").html($("#load-head").html() + ' .');
    }

    function clearLoading() {
        $("#load-head").html('');
    }

    function errorLoadRaffles() {
        $("#load-head").html('<span style="color:red">Ошибка загрузки</span>');
    }

    function endRaffles() {
        $("#load-head").html('<span style="color:grey">Больше нет конкурсов</span>');
    }

</script>
