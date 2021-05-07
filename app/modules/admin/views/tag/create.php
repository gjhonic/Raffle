<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model object */

$this->title = 'Добавление тега';
$this->params['breadcrumbs'][] = ['label' => 'Теги', 'url' => Url::to('/admin/tag/')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'but_title' => 'Сохранить',
    ]) ?>

</div>
