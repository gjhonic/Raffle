<?php

use app\models\base\Address;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $model \app\models\base\Address */

$this->title = 'Редактирование';
$this->params['breadcrumbs'][] = ['label' => 'IP адреса', 'url' => Url::to('/admin/address/')];
$this->params['breadcrumbs'][] = ['label' => $model->ip, 'url' => [Url::to('/admin/address/view'), 'id'=>$model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <p>
        <?= $form->field($model, 'ip')->textInput(['disabled' => true]) ?>
    </p>

    <p>
        <?= $form->field($model, 'note')->textInput([]) ?>
    </p>

    <p>
        <?= $form->field($model, 'status_id')->dropDownList(Address::getStatuses()); ?>
    </p>

    <p>
        <?= $form->field($model, 'description')->textarea(['rows' => '4']) ?>
    </p>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>