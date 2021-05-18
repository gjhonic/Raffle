<?php

/* @var $user object */

use yii\helpers\Html;
use yii\helpers\URL;

$this->title = 'Профиль '.$user->username;

?>
    <div id="main">

        <?php foreach ($Raffles as $raffle){ ?>

            <article class="post">
                <header>
                    <div class="title">
                        <h2><a href="single.html"><?=$raffle->title?></a></h2>
                    </div>
                    <div class="meta">
                        <time class="published" datetime="2015-11-01"><?=date('j F, Y', $raffle->updated_at)?></time>
                        <!--<a href="#" class="author"><span class="name">Jane Doe</span><img src="images/avatar.jpg" alt=""></a>-->
                    </div>
                </header>
                <p><?=$raffle->short_description?></p>
                <footer>
                    <ul class="actions">
                        <li><a href="<?=URL::to('/show/').$raffle->code?>" class="button large">Подробнее...</a></li>
                    </ul>
                </footer>
            </article>

        <?php } ?>

        <?php if($Raffles != null){ ?>
            <!-- Pagination -->
            <ul class="actions pagination">
                <li><a href="" class="disabled button large previous">Previous Page</a></li>
                <li><a href="#" class="button large next">Next Page</a></li>
            </ul>
        <?php } ?>
    </div>

    <!-- Sidebar -->
    <section id="sidebar">

        <!-- Intro -->
        <section id="intro">
            <a href="#" class="logo"><img src="images/logo.jpg" alt="" /></a>
            <header>
                <h2><?=$user->username?></h2>
                <p><?=$user->surname.' '.$user->name?></p>
            </header>
        </section>

        <!-- About -->
        <section class="blurb">
            <h2>About</h2>
            <p>Mauris neque quam, fermentum ut nisl vitae, convallis maximus nisl. Sed mattis nunc id lorem euismod amet placerat. Vivamus porttitor magna enim, ac accumsan tortor cursus at phasellus sed ultricies.</p>
            <ul class="actions">
                <?php if($user->id == Yii::$app->user->identity->id){ ?>
                    <p>
                        <?php echo Html::a('Добавить конкурс', Url::to('/raffle/create'), ['class' => 'button large'])?>
                    </p>
                <?php } ?>
            </ul>
        </section>

        <!-- Footer -->
        <section id="footer">
            <ul class="icons">
                <li><a href="#" class="icon brands fa-youtube"><span class="label">Twitter</span></a></li>
                <li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
                <li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
                <li><a href="#" class="icon solid fa-rss"><span class="label">RSS</span></a></li>
                <li><a href="#" class="icon solid fa-envelope"><span class="label">Email</span></a></li>
            </ul>
        </section>

    </section>

</div>
