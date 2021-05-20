<?php

/* @var $user object */
/* @var $model object */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\URL;

$this->title = 'Настройка';

?>
<header id="header">
    <a href="#" class="logo">Настройки / Все</a>
</header>

<section id="banner">
    <div class="content">
        <header>
            <h1>
                <?= Html::encode($this->title) ?>
            </h1>
            <p></p>
        </header>
    </div>
    <span class="image object">
            <?php if($user->existAva()){ ?>
                <img src="images/pic10.jpg" alt="" />
            <?php }else{ ?>
                <a href="" title="Изменить"><img src="/app/media/avatars/default_ava.png" alt="" /></a>
            <?php } ?>
        </span>
</section>

<section id="banner">
    <div class="content">

        <?php $form = ActiveForm::begin(); ?>

        <p>
            <?= $form->field($model, 'name')->textInput() ?>
        </p>

        <p>
            <?= $form->field($model, 'surname')->textInput() ?>
        </p>

        <p>
            <?= $form->field($model, 'username')->textInput() ?>
        </p>

        <p>
            <?= $form->field($model, 'code')->hint('Отображается в адресной строке')->textInput() ?>
        </p>

        <p>
            <?= $form->field($model, 'about')->textarea(['rows' => '3']) ?>
        </p>

        <p>
            <br>
            <?= Html::submitButton("Сохранить", ['class' => 'button large fit']) ?>
        </p>

        <?php ActiveForm::end(); ?>

    </div>
</section>