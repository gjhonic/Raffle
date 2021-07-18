<?php

/* @var $user object */
/* @var $RafflesApproved \app\models\db\Raffle */
/* @var $RafflesChecked \app\models\db\Raffle */
/* @var $RafflesNotApproved \app\models\db\Raffle */

use yii\helpers\Html;
use yii\helpers\URL;

$this->title = 'Профиль '.$user->username;

?>

<header id="header">
    <a href="#" class="logo">profile / <?=$user->code?></a>
    <ul class="icons">
        <li><a href="#" class="icon brands fa-vk"><span class="label">Twitter</span></a></li>
        <li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
        <li><a href="#" class="icon brands fa-instagram"><span class="label">Snapchat</span></a></li>
        <li><a href="#" class="icon brands fa-discord"><span class="label">Instagram</span></a></li>
        <li><a href="#" class="icon brands fa-youtube"><span class="label">Medium</span></a></li>
    </ul>
</header>

<section>
    <header class="main">
        <h1>
            <?php if(($hello_message = $user->getHelloMessage()) !== null) { ?>
                <?=$hello_message?>
            <?php }else{ ?>
                Привет я, <?=$user->surname." ".$user->name?>
            <?php } ?>
        </h1>
    </header>
    <span class="image main">
        <?php if($user->existAva()){ ?>
            <img src="images/pic10.jpg" alt="" />
        <?php }else{ ?>
            <img src="/app/media/src/raffle/pic11.jpg" alt="">
        <?php } ?>
    </span>
    <h3>
        <?php if(($about_message = $user->getAboutMessage()) !== null){ ?>
            <?=$about_message?>
        <?php }else{ ?>
            Я просто веселый человег!)
        <?php }?>
    </h3>
</section>

<?php if($user->id === Yii::$app->user->identity->getId()) { ?>
    <?= $this->render('raffle_profile/my_raffle', [
        'RafflesApproved' => $RafflesApproved,
        'RafflesChecked' => $RafflesChecked,
        'RafflesNotApproved' => $RafflesNotApproved,
        'user' => $user
    ]) ?>
<?php }else{ ?>
    <?= $this->render('raffle_profile/other_raffle', [
        'RafflesApproved' => $RafflesApproved,
        'user' => $user
    ]) ?>
<?php } ?>

