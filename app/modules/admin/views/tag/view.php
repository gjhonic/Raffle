<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\ModelWindow;
use yii\helpers\Url;

/* @var $model object */

$this->title = "Тег: ".$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Теги', 'url' => Url::to('/admin/tag/')];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-outline-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить тег: '.$model->title.'?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title'
        ],
    ]) ?>



</div>
