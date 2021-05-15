<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Подтврерждение почты';
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Вам на почту было отправлено письмо с кодом подтверждения</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'code')->textInput(['autofocus' => true]) ?>


    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            <a href="<?=Url::to('/return-confirm-email')?>" class="btn btn-warning" id="but_return" disabled>Отправить код заново через: <span id="timer_but"> 30 </span> </a>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>

    function timer(){
        let obj=document.getElementById('timer_but');
        let RealTimer = Number(obj.innerHTML);
        if (--RealTimer < 0) RealTimer = 0;
        obj.innerHTML = RealTimer;

        if (RealTimer==0) {
            let but=document.getElementById('but_return');
            but.removeAttribute("disabled");
            but.innerHTML = "Отправить код";
            return;
        }
        else { setTimeout(timer,1000); }
    }
    setTimeout(timer,30);

</script>

