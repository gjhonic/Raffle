<?php

/* @var $this yii\web\View */
/* @var $Users array */
/* @var $Raffles array */

$this->title = 'Конкурсы';
use yii\helpers\Html;
use yii\helpers\URL;
?>

<header id="header">
    <a href="#" class="logo">Конкурсы / Все</a>
    <ul class="icons">
        <li><a class="icon solid fa-search" onclick="showSearchInput()" title="Поиск" style="cursor: pointer"><span class="label">Поиск</span></a></li>
        <li><a class="icon solid fa-sort" onclick="showFilterInput()" title="Фильтр" style="cursor: pointer"><span class="label">Фильтр</span></a></li>
    </ul>
</header>

<section id="banner">
    <div class="content">

        <div id="box-filter">
            <form method="get" action="<?=Url::to('/raffle/index')?>">
                <div class="row">
                    <div class="col-3 col-12-small">
                        <p>
                            <select name="filter_date">
                                <option value="new" selected>По дате: Сначала новые</option>
                                <option value="old">По дате: Сначала старые</option>
                                <option value="0">По дате: Не учитывать</option>
                            </select>
                        </p>
                    </div>
                    <div class="col-3 col-12-small">
                        <p>
                            <select name="filter_abc">
                                <option value="abc" selected>По алфавиту: Абв...</option>
                                <option value="zyx">По алфавиту: Яюэ....</option>
                                <option value="0" selected>По алфавиту: Не учитывать</option>
                            </select>
                        </p>
                    </div>
                    <div class="col-3 col-12-small">
                        <p>
                            <select name="filter_group">
                                <option value="user">Группировка: По автору</option>
                                <option value="0" selected>Группировка: Не учитывать</option>
                            </select>
                        </p>
                    </div>
                    <div class="col-3 col-12-small">
                        <p>
                            <button class="button primary fit">Применить</button>
                        </p>
                    </div>
                </div>
            </form>
        </div>

        <div id="box-search">
            <form method="get" action="<?=Url::to('/search')?>">
                <div class="row">
                    <div class="col-6 col-12-small">
                        <p>
                            <input type="text" name="q" id="input-search-by-site" placeholder="Поиск" />
                        </p>
                    </div>
                    <div class="col-6 col-12-small">
                        <p>
                            <button class="button primary fit">Искать</button>
                        </p>
                    </div>
                    <span>Я буду искать совпадения средки конкурсов, пользователей и тегов</span>
                </div>
            </form>
        </div>

        <h1><?= Html::encode($this->title) ?></h1>

        <div id="box-raffles">
            <?php foreach ($Raffles as $raffle){ ?>
                <div class="box">
                    <article class="post">
                        <header>
                            <div class="title">
                                <h2><a href="<?=URL::to('/show/').$raffle['raffle_code']?>"><?=$raffle['raffle_title']?></a></h2>
                            </div>

                            <div class="meta">
                                <time class="published"><?=date('d.n.Y', $raffle['raffle_created_at'])?></time>
                            </div>
                        </header>

                        <p><?=$raffle['raffle_short_description']?></p>
                        <footer>
                            <ul class="actions">
                                <li>
                                    <a href="<?=URL::to('/show/').$raffle['raffle_code']?>" class="button">Подробнее...</a>
                                </li>
                                <li>
                                    <?=Html::a('Автор: '.$raffle['username'], URL::to('/profile').'/'.$raffle['user_code'], ['class' => 'button',])?>
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
    function showFilterInput(){
        $("#box-filter").show();
        $("#box-search").hide();
    }

    function showSearchInput(){
        $("#box-filter").hide();
        $("#box-search").show();
    }

    function showHideInput(){
        $("#box-filter").hide();
        $("#box-search").hide();
    }

    showHideInput();

    let page = 1;

    function loadRaffle(){
        let csrfToken = $('meta[name="csrf-token"]').attr("content");
        let filter_date = '<?=Yii::$app->request->get('filter_date')?>';
        let filter_abc = '<?=Yii::$app->request->get('filter_abc')?>';
        let filter_group = '<?=Yii::$app->request->get('filter_group')?>'
        $.ajax({
            url: '/raffle/get-raffles-json',
            type: 'GET',
            dataType: 'json',
            data: {filter_date: filter_date, filter_abc: filter_abc, filter_group: filter_group, page: page, _csrf: csrfToken},
            success: function(res){
                $('#load-head').html('Загрузка');
                let timerId = setInterval(() => addPointForLoading(), 200);
                setTimeout(() => {clearInterval(timerId); clearLoading(); setRaffleFromLoad(res); }, 700);
                page++;
            },
            error: function(){
                $('#load-head').html('Загрузка');
                let timerId = setInterval(() => addPointForLoading(), 200);
                setTimeout(() => {clearInterval(timerId); errorLoadRaffles(); }, 700);
            }
        });
    }

    function setRaffleFromLoad(raffle){
        for(let i = 0; i<10; i++){
            let raffle_title = raffle[i].raffle_title;
            let raffle_code = raffle[i].raffle_code;
            let raffle_short_description = raffle[i].raffle_short_description;
            let raffle_created_at = raffle[i].raffle_created_at;
            let d = new Date(raffle_created_at*1000);
            raffle_created_at = d.getDate() + '.' + (d.getMonth()+1) + '.' + d.getFullYear();
            let username = raffle[i].username;
            let user_code = raffle[i].user_code;

            $("#box-raffles").append("<div class='box'><article class='post'>" +
                "<header> <div class='title'><h2>" +
                "<a href='/show/"+ raffle_code + "'>" + raffle_title + "</a><h2></div>" +
                "<div class='meta'><time class='published'>" + raffle_created_at + "</time></div></header>" +
                "<p>" + raffle_short_description + "</p>" +
                "<footer><ul class='actions'><li><a href='/show/"+ raffle_code + "' class='button'>Подробнее...</a></li>" +
                "<li><a href='/profile/"+ user_code + "' class='button'>Автор: " + username + "</a></li></ul></footer></article></div>"
            );
        }
    }


    function addPointForLoading(){
        $("#load-head").html($("#load-head").html()+' .');
    }
    function clearLoading(){
        $("#load-head").html('');
    }
    function errorLoadRaffles(){
        $("#load-head").html('<span style="color:red">Ошибка загрузки</span>');
    }

</script>
