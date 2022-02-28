<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $dataProvider \yii\db\ActiveRecord */
/* @var $searchModel \app\modules\admin\models\search\ActionCronSearch */

$this->title = 'Логи крон скриптов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="action-cron-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div style="overflow-x: auto;">
        <?php
        Pjax::begin(); ?>
        <?= GridView::widget(
            [
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'controller',
                    'action',
                    [
                        'label' => 'Время использования',
                        'value' => function ($model) {
                            return date('Y-m-d H:i:s', $model->created_at);
                        }
                    ],
                ],
            ]
        ); ?>
        <?php
        Pjax::end(); ?>
    </div>
</div>
