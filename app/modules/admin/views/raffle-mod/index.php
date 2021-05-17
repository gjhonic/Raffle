<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\modules\admin\widget\RaffleStatusWidget;

/* @var $dataProvider \yii\db\ActiveRecord */
/* @var $searchModel \app\models\db\search\UserSearch */
/* @var $Statuses array */

$this->title = 'Модерация конкурсов';
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
                    'attribute' => 'user_id',
                    'value' => function ($data) {
                        $user = $data->getUser();
                        return "<a href='".URL::to('/admin/user/view')."?id=".$user->id."'>".$user->username."</a>";
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'status_id',
                    'filter' => RaffleStatusWidget::statusList(),
                    'value' => function ($data) {
                        return RaffleStatusWidget::statusLabel($data->status_id);
                    },
                    'format' => 'raw',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => "{view}",
                    'buttons' => [
                        'view' => function ($url,$data) {
                            return "<div class='d-grid gap-2'>".Html::a('Смотреть', Url::to('/admin/raffle/view').'?id='.$data->id, ['class' => 'btn btn-outline-primary'])."</div>";
                        },
                    ],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => "{update}",
                    'buttons' => [
                        'update' => function ($url,$data) {
                            if($data->status_id == 1){
                                return "<div class='d-grid gap-2'>".Html::a('Запретить', Url::to('/admin/raffle-mod/ban')."?id=".$data->id, ['class' => 'btn btn-outline-danger btn-block', 'data' => [
                                        'confirm' => 'Вы действительнос хотите запретить конкурс '.$data->title.'?',
                                        'method' => 'post',
                                    ]])."</div>";
                            }elseif($data->status_id == 2){
                                return "<div class='d-grid gap-2'>".Html::a('Одобрить', Url::to('/admin/raffle-mod/unban')."?id=".$data->id, ['class' => 'btn btn-outline-success btn-block', 'data' => [
                                        'confirm' => 'Вы действительнос хотите одобрить конкурс '.$data->title.'?',
                                        'method' => 'post',
                                    ]]).Html::a('Запретить', Url::to('/admin/raffle-mod/ban')."?id=".$data->id, ['class' => 'btn btn-outline-danger btn-block', 'data' => [
                                        'confirm' => 'Вы действительнос хотите запретить конкурс '.$data->title.'?',
                                        'method' => 'post',
                                    ]])."</div>";
                            }
                            elseif($data->status_id == 3){
                                return "<div class='d-grid gap-2'>".Html::a('Одобрить', Url::to('/admin/raffle-mod/unban')."?id=".$data->id, ['class' => 'btn btn-outline-success btn-block', 'data' => [
                                        'confirm' => 'Вы действительнос хотите одобрить конкурс '.$data->title.'?',
                                        'method' => 'post',
                                    ]])."</div>";
                            }
                        },
                    ],
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
