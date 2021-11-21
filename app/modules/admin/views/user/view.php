<?php

/* @var $model \app\models\db\User */

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;


$this->title = $model->surname." ".$model->name." (".$model->username.")";
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => Url::to('/admin/user/')];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'surname',
            'name',
            [
                'attribute'=>'role_id',
                'label' => 'Роль',
                'format' => 'raw',
                'value'=> $model->role->title,

            ],
            [
                'attribute'=>'status_id',
                'label' => 'Статус',
                'format' => 'raw',
                'value'=> $model->status->title,

            ],
        ],
    ]) ?>



</div>
