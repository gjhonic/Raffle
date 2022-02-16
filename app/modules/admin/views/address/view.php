<?php

use app\models\base\Address;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $model \app\models\base\Address */

$this->title = "IP адрес: ".$model->ip;
$this->params['breadcrumbs'][] = ['label' => 'IP адреса', 'url' => Url::to('/admin/address/')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ip',
            [
                'attribute' => 'status_id',
                'filter' => Address::getStatuses(),
                'value' => function ($model) {
                    return Address::getStatus($model->status_id);
                }
            ],
            'note',
            'description',
            [
                'label' => 'Дата добавления',
                'value' => function ($model) {
                    return date('Y-m-d H:i:s', $model->created_at);
                }
            ],
            [
                'label' => 'Дата изменения',
                'value' => function ($model) {
                    return date('Y-m-d H:i:s', $model->updated_at);
                }
            ],
        ],
    ]) ?>

    <br>
</div>
