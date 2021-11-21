<?php

/* @var $dataProvider */
/* @var $searchModel */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Теги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить тег', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div style="overflow-x: auto;">
        <?php Pjax::begin(); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'  => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'title',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => "{view} {update}",
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('Смотреть', $url, ['class' => 'btn btn-outline-success btn-block']);
                            },

                            'update' => function ($url, $model, $key) {
                                return Html::a('Изменить', $url, ['class' => 'btn btn-outline-primary btn-block']);
                            },

                        ],
                    ],
                ],
            ]); ?>

        <?php Pjax::end(); ?>
    </div>
</div>
