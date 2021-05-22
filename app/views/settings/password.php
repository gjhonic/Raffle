<?php

/* @var $user object */
/* @var $model object */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\URL;

$this->title = 'Настройка пароля';

?>
<header id="header">
    <a href="#" class="logo"><span onclick="window.location.replace('<?=URL::to('/settings/index')?>');">Настройки </span> / Профиля</a>
</header>

<section id="banner">
    <div class="content">
        <header>
            <h1>
                <?= Html::encode($this->title) ?>
            </h1>
            <p></p>
        </header>
        <p>

            <?php $form = ActiveForm::begin(); ?>

        <p>
            <?= $form->field($model, 'password_old')->textInput() ?>
        </p>

        <p>
            <?= $form->field($model, 'password_new')->textInput() ?>
        </p>

        <p>
            <?= $form->field($model, 'password_new_confirm')->textInput() ?>
        </p>

        <p>
            <br>
            <?= Html::submitButton("Сохранить", ['class' => 'button large fit']) ?>
        </p>

        <?php ActiveForm::end(); ?>
        </p>
    </div>
</section>