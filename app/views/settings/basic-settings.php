<?php

use app\assets\FrontendAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $model object */

$this->title = Yii::t('app', 'Basic settings');

$this->registerJsFile('/media/general/js/generate_code.js', ['depends' => [FrontendAsset::className()], 'position' => \yii\web\View::POS_END]);

?>
<header id="header">
    <a href="#" class="logo">
        <span onclick="window.location.replace('<?= URL::to('/settings/index') ?>');">
            <?= Yii::t('app', 'Settings') ?>
        </span>
        / <?= Yii::t('app', 'Basic settings') ?>
    </a>
</header>

<section id="banner">
    <div class="content">
        <header>
            <h1>
                <?= Html::encode($this->title) ?>
            </h1>
        </header>

        <?php $form = ActiveForm::begin(); ?>
        <div>
            <div class="row">
                <div class="col-6">
                    <?= $form->field($model, 'name')->textInput() ?>
                </div>
                <div class="col-6">
                    <?= $form->field($model, 'surname')->textInput() ?>
                </div>
            </div>

            <p class="row">
                <?= $form->field($model, 'username')->textInput() ?>
            </p>

            <label><?=Yii::t('app', 'Code')?></label>
            <div class="row">
                <div class="col-6">
                    <?= Html::input('text', 'SettingForm[code]', $model->code, ['id' => 'field-user-code', 'class' => 'form-control']) ?>
                </div>
                <div class="col-6">
                    <span class="button primary fit" onclick="setCodeGenerate('field-user-code')"><?=Yii::t('app', 'Generate code')?></span>
                </div>
            </div>

            <p>
                <?= $form->field($model, 'about')->textarea(['rows' => '3']) ?>
            </p>

            <p>
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'button large fit']) ?>
            </p>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</section>