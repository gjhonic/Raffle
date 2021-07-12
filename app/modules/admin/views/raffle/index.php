<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\models\db\User;
use app\modules\admin\widget\RaffleStatusWidget;

/* @var $dataProvider \yii\db\ActiveRecord */
/* @var $searchModel \app\models\db\search\UserSearch */

$this->title = 'Конкурсы';
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

                'title',
                [
                    'attribute' => 'status_id',
                    'filter' => RaffleStatusWidget::statusList(),
                    'value' => function ($data) {
                        return RaffleStatusWidget::statusLabel($data->status_id);
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'user_id',
                    'value' => function ($data) {
                        $user = $data->getUser();
                        return "<a href='".URL::to('/admin/user/view')."?id=".$user->id."'>".$user->username."</a>";
                    },
                    'format' => 'raw',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => "{view}",
                    'buttons' => [
                        'view' => function ($url,$model,$key) {
                            return Html::a('Смотреть', $url, ['class' => 'btn btn-outline-success btn-block']);
                        },
                    ],
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
