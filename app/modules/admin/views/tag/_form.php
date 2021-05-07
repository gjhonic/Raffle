<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model object */
/* @var $but_title string */
?>
<div class="group-form">

    <?php $form = ActiveForm::begin(); ?>

    <p>
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </p>

    <div class="form-group">
        <?= Html::submitButton($but_title, ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
