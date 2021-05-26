<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model object */
/* @var $but_title string */
?>

<?php $form = ActiveForm::begin(); ?>

    <p>
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </p>

    <p>
        <?= $form->field($model, 'description')->textarea(['rows' => '6']) ?>
    </p>

    <p>
        <br>
        <?= Html::submitButton('Отправить', ['class' => 'button large fit']) ?>
    </p>

<?php ActiveForm::end(); ?>