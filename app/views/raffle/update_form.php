<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use kartik\datetime\DateTimePicker;

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
    <h5>Код</h5>
    <div class="row">
        <div class="col-6 col-12-small">
            <p>
                <input type="text" id="input-code" placeholder="Код" name="RaffleForm[code]" maxlength='25'>
            </p>
        </div>
        <div class="col-6 col-12-small">
            <p>
                <span class="button primary fit" onclick="codeGenerate()">Сгенерировать код</span>
            </p>
        </div>
        <span>Отображается в адресной строке, оставьте пустым и произойдет автоматическая генерация</span>
    </div>
    </p>


    <div class="row">
        <div class="col-6 col-12-small">
            <p>
            <div class="form-group">
                <label for="date_begin" class="control-label">Дата начала конкурса</label>
                <input type="date" 0 class="form-control" id="date_begin" placeholder="" name="RaffleForm[date_begin]" value="<?=date('Y-m-d')?>" min="2021-01-01" max="2050-12-31">
            </div>
            </p>
        </div>
        <div class="col-6 col-12-small">
            <p>
            <div class="form-group">
                <label for="date_begin" class="control-label">Дата начала конкурса</label>
                <input type="date" 0 class="form-control" id="date_begin" placeholder="" name="RaffleForm[date_end]" value="<?=date('Y-m-d')?>" min="2021-01-01" max="2050-12-31">
            </div>
            </p>
        </div>
    </div>


    <p>
        <br>
        <?= Html::submitButton($but_title, ['class' => 'button large fit']) ?>
    </p>

<?php ActiveForm::end(); ?>

<script>
    function codeGenerate(){
        let result           = '';
        let characters       = 'abcdefghijklmnopqrstuvwxyz0123456789';
        let charactersLength = characters.length;
        for ( let i = 0; i < 25; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        document.getElementById('input-code').value = result;
    }
</script>
