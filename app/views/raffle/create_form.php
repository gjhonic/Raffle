<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;

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
        <?= $form->field($model, 'description')->widget(CKEditor::className(),[
            'editorOptions' => [
                'preset' => 'full',
                'inline' => false,
            ],
        ]); ?>
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
                <input type="date" class="form-control" id="date_begin" placeholder="" name="RaffleForm[date_begin]" value="<?=date('Y-m-d')?>" min="2021-01-01" max="2050-12-31">
            </div>
            </p>
        </div>
        <div class="col-6 col-12-small">
            <p>
            <div class="form-group">
                <label for="date_begin" class="control-label">Дата окончания конкурса</label>
                <input type="date" class="form-control" id="date_begin" placeholder="" name="RaffleForm[date_end]" value="" min="2021-01-01" max="2050-12-31">
            </div>
            </p>
        </div>
    </div>

    <h5>Теги</h5>
    <div class="form-group">
        <textarea name="RaffleForm[tags]" rows="3" id="textarea-tags" style="font-size: 15px; resize: none;" maxlength="255" disabled></textarea>
    </div>
    <p>
    <div class="row">
        <div class="col-6 col-12-small">
            <p>
                <input type="text" id="input-tag" placeholder="Введите новый тег" maxlength='25'>
            </p>
        </div>
        <div class="col-6 col-12-small">
            <p>
                <span class="button primary fit" onclick="addTag()">Добавить тег</span>
            </p>
        </div>
        <span>Теги нужны, с ними пользователи смогут быстрее найти ваш конкурс</span>
    </div>
    </p>


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
        $('#input-code').val(result);
    }

    function addTag(){
        let tags = $('#textarea-tags').val();
        let tag = $('#input-tag').val();
        let tags_added = tags+" #"+tag;
        if(tags_added.length <= 255){
            $('#textarea-tags').val(tags+" #"+tag);
            $('#input-tag').val('');
        }else{
            alert("Слишком много тегов");
        }
    }
</script>
