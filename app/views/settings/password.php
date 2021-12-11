<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $user object */
/* @var $model object */

$this->title = Yii::t('app', 'Password setting');

?>

<header id="header">
    <a href="#" class="logo">
        <span onclick="window.location.replace('<?= URL::to('/settings/index') ?>');">
            <?= Yii::t('app', 'Settings') ?>
        </span>
        / <?= Yii::t('app', 'Password setting') ?>
    </a>
</header>

<section id="banner">
    <div class="content">
        <header>
            <h1>
                <?= Html::encode($this->title) ?>
            </h1>
        </header>

        <?php $form = ActiveForm::begin(); ?>

        <label><?= Yii::t('app', 'Current Password') ?></label>
        <div class="row">
            <div class="col-6">
                <?= Html::input('password', 'SettingPasswordForm[password_old]', $model->password_old, ['id' => 'field-password_old', 'class' => 'form-control']) ?>
            </div>
            <div class="col-4">
                <span class="button" id="button-change-type-password-old" onclick="changeTypeInput('field-password_old', 'button-change-type-password-old')">👀</span>
            </div>
        </div>

        <label><?= Yii::t('app', 'New password') ?></label>
        <div class="row">
            <div class="col-6">
                <?= Html::input('password', 'SettingPasswordForm[password_new]', $model->password_new, ['id' => 'field-password_new', 'class' => 'form-control']) ?>
            </div>
            <div class="col-4">
                <span class="button" id="button-change-type-password-new" onclick="changeTypeInput('field-password_new', 'button-change-type-password-new')">👀</span>
            </div>
        </div>

        <label><?= Yii::t('app', 'Confirm the password') ?></label>
        <div class="row">
            <div class="col-6">
                <?= Html::input('password', 'SettingPasswordForm[password_new_confirm]', $model->password_new_confirm, ['id' => 'field-new_confirm', 'class' => 'form-control']) ?>
            </div>
            <div class="col-4">
                <span class="button" id="button-change-type-password-confirm" onclick="changeTypeInput('field-new_confirm', 'button-change-type-password-confirm')">👀</span>
            </div>
        </div>

        <p>
            <br>
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'button large fit']) ?>
        </p>

        <?php ActiveForm::end(); ?>
    </div>
</section>

<script>
    function changeTypeInput(Idfield, button) {
        let input = $("#" + Idfield);
        let type = input.attr('type');

        console.log(type);

        if (type == 'password') {
            input.attr('type', 'text')
            $("#" + button).attr('class', 'button primary');

        } else {
            input.attr('type', 'password')
            $("#" + button).attr('class', 'button');
        }
    }
</script>