<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;

/* @var $model object */
?>

<?php $form = ActiveForm::begin(); ?>

    <p>
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </p>

    <p>
        <?= $form->field($model, 'short_description')->textarea(['rows' => '4']) ?>
    </p>

    <p>
        <?= $form->field($model, 'description')->widget(CKEditor::className(),[
            'editorOptions' => [
                'preset' => 'full',
                'inline' => false,
            ],
        ]); ?>
    </p>

    <input type="hidden" name="code_old" value="<?=$model->code?>">

    <p>
    <h5>Код</h5>
    <div class="row">
        <div class="col-6 col-12-small">
            <p>
                <input type="text" id="input-code" name="RaffleForm[code]" maxlength='25' value="<?=$model->code?>">
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
                <input type="date" 0 class="form-control" id="date_begin" placeholder="" name="RaffleForm[date_begin]" value="<?=$model->date_begin?>" min="2021-01-01" max="2050-12-31">
            </div>
            </p>
        </div>
        <div class="col-6 col-12-small">
            <p>
            <div class="form-group">
                <label for="date_end" class="control-label">Дата окончания конкурса</label>
                <input type="date" 0 class="form-control" id="date_end" placeholder="" name="RaffleForm[date_end]" value="<?=$model->date_end?>" min="2021-01-01" max="2050-12-31">
            </div>
            </p>
        </div>
    </div>


    <p>
        <br>
        <?= Html::submitButton("Сохранить", ['class' => 'button large fit']) ?>
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
