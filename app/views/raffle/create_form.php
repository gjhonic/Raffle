<?php

use app\assets\FrontendAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\CustomCKEditor;

/* @var $model object */
/* @var $butTitle string */

$this->registerJsFile('/media/general/js/generate_code.js', ['depends' => [FrontendAsset::className()], 'position' => \yii\web\View::POS_END]);
?>

<?php $form = ActiveForm::begin(); ?>

    <p>
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </p>

    <p>
        <?= $form->field($model, 'short_description')->textarea(['rows' => '4']) ?>
    </p>

    <p>
        <?= $form->field($model, 'description')->widget(CustomCKEditor::className(),[
            'editorOptions' => [
                'preset' => 'full',
                'inline' => false,
            ],
        ]); ?>
    </p>

    <p>
        <h5><?=Yii::t('app', 'Code')?></h5>
        <div class="row">
            <div class="col-6 col-12-small">
                <p>
                    <input type="text" id="input-code" placeholder="<?=Yii::t('app', 'Code')?>" name="RaffleForm[code]" maxlength='25'>
                </p>
            </div>
            <div class="col-6 col-12-small">
                <p>
                    <span class="button primary fit" onclick="setCodeGenerate('input-code')">Сгенерировать код</span>
                </p>
            </div>
            <span><?=Yii::t('app/note', 'It is displayed in the address bar, leave it blank and it will be automatically generated')?></span>
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
        <textarea name="RaffleForm[tags]" rows="3" id="textarea-tags" style="font-size: 15px; resize: none;" maxlength="255" readonly></textarea>
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
        <?= Html::submitButton($butTitle, ['class' => 'button large fit']) ?>
    </p>

<?php ActiveForm::end(); ?>

<script>
    function addTag(){
        let tags = $('#textarea-tags').val();
        let tag = $('#input-tag').val();
        tag = tag.trim();
        let new_tag = tag.split(' ').join('_');
        let tags_added = tags+" #"+new_tag;
        if( tag !== ''){
            if(tags_added.length <= 255){
                $('#textarea-tags').val(tags_added);
                $('#input-tag').val('');
            }else{
                alert("Слишком много тегов");
            }
        }else{
            $('#input-tag').val('');
        }
    }

    CKEDITOR.editorConfig = function( config ) {
        config.toolbarGroups = [
            { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
            { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
            { name: 'forms', groups: [ 'forms' ] },
            '/',
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
            { name: 'links', groups: [ 'links' ] },
            { name: 'insert', groups: [ 'insert' ] },
            '/',
            { name: 'styles', groups: [ 'styles' ] },
            { name: 'colors', groups: [ 'colors' ] },
            { name: 'tools', groups: [ 'tools' ] },
            { name: 'others', groups: [ 'others' ] },
            { name: 'about', groups: [ 'about' ] }
        ];

        config.removeButtons = 'Link,Unlink,Anchor,Image,Table,HorizontalRule,SpecialChar,PageBreak,Iframe,Language,BidiLtr,CreateDiv,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Templates,Save,Source,NewPage,ExportPdf,Preview,Print';
    };

</script>
