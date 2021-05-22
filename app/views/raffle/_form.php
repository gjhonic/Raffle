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
        <?= $form->field($model, 'short_description')->textarea(['rows' => '4']) ?>
    </p>

    <p>
        <?= $form->field($model, 'description')->textarea(['rows' => '6']) ?>
    </p>

    <p>
        <?= $form->field($model, 'code')->hint('Отображается в адресной строке')->textInput(['maxlength' => true]) ?>
    </p>

    <p>
        <br>
        <?= Html::submitButton($but_title, ['class' => 'button large fit']) ?>
    </p>

<?php ActiveForm::end(); ?>
