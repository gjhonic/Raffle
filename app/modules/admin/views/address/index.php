<?php

use app\models\base\Address;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $dataProvider \yii\db\ActiveRecord */
/* @var $searchModel \app\models\base\search\UserSearch */

$this->title = 'IP адреса';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div style="overflow-x: auto;">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'ip',
                    'label' => 'Адресс',
                    'value' => function ($model) {
                        return $model->ip;
                    }
                ],
                [
                    'attribute' => 'status_id',
                    'filter' => Address::getStatuses(),
                    'value' => function ($model) {
                        return Address::getStatus($model->status_id);
                    }
                ],
                'note',
                [
                    'label' => 'Время использования',
                    'value' => function ($model) {
                        return date('Y-m-d H:i:s', $model->created_at);
                    }
                ],
                [
                    'label' => '',
                    'format' => 'raw',
                    'value' => function ($model){
                        return "<div class='d-grid gap-2'>"
                            . Html::a('Смотреть', Url::to(['view', 'id' => $model->id]), ['class' => 'btn btn-outline-success btn-block'])
                            . Html::a('Редактировать', Url::to(['update', 'id' => $model->id]), ['class' => 'btn btn-outline-primary btn-block'])
                            . "</div>";
                    }
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
