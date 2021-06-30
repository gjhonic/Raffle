<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

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
        <?= $form->field($model, 'code')->hint('Отображается в адресной строке, оставьте пустым и произойдет автоматическая генерация')->textInput(['maxlength' => true]) ?>
    </p>

    <div class="form-group">
        <label for="date_begin" class="control-label">Дата начала конкурса</label>
        <input type="date" class="form-control" id="date_begin" placeholder="" name="RaffleForm[date_begin]" value="<?=date('Y-m-d')?>" min="2021-01-01" max="2050-12-31">
    </div>

    <p>
        <br>
        <?= Html::submitButton($but_title, ['class' => 'button large fit']) ?>
    </p>

<?php ActiveForm::end(); ?>
