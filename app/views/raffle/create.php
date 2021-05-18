<?php

use yii\helpers\Html;

/* @var $model object */

$this->title = 'Добавление конкурса';
?>
<div id="main">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'but_title' => 'Добавить',
    ]) ?>

