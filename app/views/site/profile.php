<?php

/* @var $user object */

use yii\helpers\Html;
use yii\helpers\URL;

$this->title = 'Профиль '.$user->username;

?>
<div class="site-profile">
    <h1><?= Html::encode($this->title) ?></h1>

    <table>
        <tr>
            <td>
                Имя
            </td>
            <td>
                <?=$user->name?>
            </td>
        </tr>
        <tr>
            <td>
                Фамилия
            </td>
            <td>
                <?=$user->surname?>
            </td>
        </tr>
        <tr>
            <td>
                Код
            </td>
            <td>
                <?=$user->code?>
            </td>
        </tr>
    </table>

    <?php if($user->id == Yii::$app->user->identity->id){ ?>
        <p>
            <?php echo Html::a('Добавить конкурс', Url::to('/raffle/create'), ['class' => 'button large'])?>
        </p>
    <?php } ?>

    <h2>
        Конкурсы
    </h2>

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
</div>
