<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <div class="wrap-input100 validate-input m-b-16" data-validate = "Введите логин">
        <input class="input100" type="text" name="username" placeholder="Логин">
        <span class="focus-input100"></span>
    </div>


    <div class="wrap-input100 validate-input m-b-16" data-validate = "Введите пароль">
        <input class="input100" type="password" name="password" placeholder="Пароль">
        <span class="focus-input100"></span>
    </div>

    <div class="flex-sb-m w-full p-t-3 p-b-24">
        <div class="contact100-form-checkbox">
            <input class="input-checkbox100" id="ckb1" type="checkbox" name="rememberMe">
            <label class="label-checkbox100" for="ckb1">
                Запомни меня
            </label>
        </div>

    </div>

    <div class="container-login100-form-btn m-t-17">
        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>



    <?php ActiveForm::end(); ?>

</div>
