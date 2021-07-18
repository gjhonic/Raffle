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
                            <select name="filter-date">
                                <option value="new" selected>По дате: Сначала новые</option>
                                <option value="old">По дате: Сначала старые</option>
                                <option value="0">По дате: Не учитывать</option>
                            </select>
                        </p>
                    </div>
                    <div class="col-3 col-12-small">
                        <p>
                            <select name="filter-abc">
                                <option value="abc" selected>По алфавиту: Абв...</option>
                                <option value="zyx">По алфавиту: Яюэ....</option>
                                <option value="0" selected>По алфавиту: Не учитывать</option>
                            </select>
                        </p>
                    </div>
                    <div class="col-3 col-12-small">
                        <p>
                            <select name="filter-group">
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

        <?php foreach ($Raffles as $raffle){ ?>
            <div class="box">
                <article class="post">
                    <header>
                        <div class="title">
                            <h2><a href="<?=URL::to('/show/').$raffle['raffle_code']?>"><?=$raffle['raffle_title']?></a></h2>
                        </div>

                        <div class="meta">
                            <time class="published" datetime="2015-11-01"><?=date('j F, Y', $raffle['raffle_created_at'])?></time>
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
        <span class="button fit">Загрузить еще</span>
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
</script>
