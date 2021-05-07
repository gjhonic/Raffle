<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model object */

$this->title = 'Изменение';
$this->params['breadcrumbs'][] = ['label' => 'Теги', 'url' => Url::to('/admin/tag/')];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => [Url::to('/admin/tag/view'), 'id'=>$model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'but_title' => 'Изменить',
    ]) ?>

</div>
