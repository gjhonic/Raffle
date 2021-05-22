<?php

/* @var $user object */
/* @var $model object */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\URL;

$this->title = 'Настройка аккаунта';

?>
<header id="header">
    <a href="#" class="logo"><span onclick="window.location.replace('<?=URL::to('/settings/index')?>');">Настройки </span> / Аккаунта</a>
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
        </p>
    </div>
</section>