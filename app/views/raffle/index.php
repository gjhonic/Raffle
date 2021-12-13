<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $Users array */
/* @var $Raffles array */

$this->title = Yii::t('app', 'Raffles');

?>

<header id="header">
    <a href="#" class="logo"><?=Yii::t('app', 'Raffles')?> / <?=Yii::t('app', 'All')?></a>
    <ul class="icons">
        <li>
            <a class="icon solid fa-search" onclick="showSearchInput()" title="<?=Yii::t('app', 'Search')?>" style="cursor: pointer">
                <span class="label"><?=Yii::t('app', 'Search')?></span>
            </a>
        </li>
        <li>
            <a class="icon solid fa-sort" onclick="showFilterInput()" title="<?=Yii::t('app', 'Filter')?>" style="cursor: pointer">
                <span class="label">Фильтр</span>
            </a>
        </li>
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
                            <button class="button primary fit"><?=Yii::t('app', 'Apply')?></button>
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
                            <input type="text" name="q" id="input-search-by-site" placeholder="<?=Yii::t('app', 'Search')?>" />
                        </p>
                    </div>
                    <div class="col-6 col-12-small">
                        <p>
                            <button class="button primary fit"><?=Yii::t("app", "Search")?></button>
                        </p>
                    </div>
                    <span><?=Yii::t("app/note", "I will search for matches of contest media, users and tags")?></span>
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
                                <h2><a href="<?=Url::to('/show/').$raffle['raffle_code']?>"><?=$raffle['raffle_title']?></a></h2>
                            </div>

                            <div class="meta">
                                <time class="published"><?=date('d.n.Y', $raffle['raffle_created_at'])?></time>
                            </div>
                        </header>

                        <p><?=$raffle['raffle_short_description']?></p>
                        <footer>
                            <ul class="actions">
                                <li>
                                    <a href="<?=Url::to('/show/').$raffle['raffle_code']?>" class="button"><?=Yii::t('app', 'More details')?>...</a>
                                </li>
                                <li>
                                    <?=Html::a('Автор: '.$raffle['username'], Url::to('/profile').'/'.$raffle['user_code'], ['class' => 'button',])?>
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
    //TODO сделать плавно
    let search_pos = 0;
    let filter_pos = 0;

    function showFilterInput(){
        if(filter_pos){
            showHideInput();
            filter_pos = 0;
            search_pos = 0;
        }else{
            $("#box-filter").show();
            $("#box-search").hide();
            filter_pos = 1;
            search_pos = 0;
        }
    }

    function showSearchInput(){
        if(search_pos){
            showHideInput();
            search_pos = 0;
            filter_pos = 0;
        }else{
            $("#box-filter").hide();
            $("#box-search").show();
            search_pos = 1;
            filter_pos = 0;
        }
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
        //TODO Юзать Fetch

        let body = {
            _csrf: csrfToken,
            filter_date: filter_date,
            filter_abc: filter_abc,
            filter_group: filter_group,
            page: page
        }

        let response = fetch('/ajax/raffle/get-raffles-json', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        })
            .then(response => {
                (res) => {
                    $('#load-head').html('Загрузка');
                    let timerId = setInterval(() => addPointForLoading(), 200);
                    if(res['data'] == false){
                        setTimeout(() => {clearInterval(timerId); clearLoading(); endRaffles(); }, 700);
                        page++;
                    }else{
                        setTimeout(() => {clearInterval(timerId); clearLoading(); setRaffleFromLoad(res['data']); }, 700);
                    }
            }})
            .catch(err => {
                () => {
                    $('#load-head').html('Загрузка');
                    let timerId = setInterval(() => addPointForLoading(), 200);
                    setTimeout(() => {clearInterval(timerId); errorLoadRaffles(); }, 700);
            }})
        

        // $.ajax({
        //     url: '/ajax/raffle/get-raffles-json',
        //     type: 'GET',
        //     dataType: 'json',
        //     data: {filter_date: filter_date, filter_abc: filter_abc, filter_group: filter_group, page: page, _csrf: csrfToken},
        //     success: function(res){
        //         $('#load-head').html('Загрузка');
        //         let timerId = setInterval(() => addPointForLoading(), 200);
        //         if(res['data'] == false){
        //             setTimeout(() => {clearInterval(timerId); clearLoading(); endRaffles(); }, 700);
        //             page++;
        //         }else{
        //             setTimeout(() => {clearInterval(timerId); clearLoading(); setRaffleFromLoad(res['data']); }, 700);
        //         }
        //     },
        //     error: function(){
        //         $('#load-head').html('Загрузка');
        //         let timerId = setInterval(() => addPointForLoading(), 200);
        //         setTimeout(() => {clearInterval(timerId); errorLoadRaffles(); }, 700);
        //     }
        // });
    }

    function setRaffleFromLoad(raffles){
        for(let i = 0; i < 10; i++){
            let raffle_title = raffles[i].raffle_title;
            let raffle_code = raffles[i].raffle_code;
            let raffle_short_description = raffles[i].raffle_short_description;
            let raffle_created_at = raffles[i].raffle_created_at;
            let d = new Date(raffle_created_at*1000);
            raffle_created_at = d.getDate() + '.' + (d.getMonth()+1) + '.' + d.getFullYear();
            let username = raffles[i].username;
            let user_code = raffles[i].user_code;

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
    function endRaffles(){
        $("#load-head").html('<span style="color:grey">Больше нет конкурсов</span>');
    }

</script>
