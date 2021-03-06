<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\modules\admin\widgets\UserStatusWidget;

/* @var $dataProvider \yii\db\ActiveRecord */
/* @var $searchModel \app\models\base\search\UserSearch */
/* @var $Statuses array */

$this->title = 'Модерация пользователей (админ)';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a('Обычный режим', Url::to('/admin/user-mod/index'), ['class' => 'btn btn-outline-primary btn-block']); ?>
    </p>

    <div style="overflow-x: auto;">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'username',
                'surname',
                'name',
                [
                    'attribute' => 'status_id',
                    'filter' => UserStatusWidget::statusList(),
                    'value' => function ($data) {
                        return UserStatusWidget::statusLabel($data->status_id);
                    },
                    'format' => 'raw',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => "{view}",
                    'buttons' => [
                        'view' => function ($url,$data) {
                            return Html::a('Смотреть', Url::to('/admin/user/view')."?id=".$data->id, ['class' => 'btn btn-outline-primary']);
                        },
                    ],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => "{update}",
                    'buttons' => [
                        'update' => function ($url,$data) {
                            if($data->status_id == 2){
                                return "<div class='d-grid gap-2'>".Html::a('Отметить бан', Url::to('/admin/user-mod/untag')."?id=".$data->id, ['class' => 'btn btn-outline-danger btn-block', 'data' => [
                                            'confirm' => 'Вы действительнос хотите отметить бан пользователя '.$data->username.'?',
                                            'method' => 'post',
                                        ]]).Html::a('Забанить', Url::to('/admin/user-mod/ban')."?id=".$data->id, ['class' => 'btn btn-outline-dark btn-block','data' => [
                                            'confirm' => 'Вы действительнос хотите забанить пользователя '.$data->username.'?',
                                            'method' => 'post',
                                        ]])."</div>";
                            }
                            elseif($data->status_id == 1){
                                return "<div class='d-grid gap-2'>".Html::a('Пометить бан', Url::to('/admin/user-mod/tag')."?id=".$data->id, ['class' => 'btn btn-outline-danger btn-block', 'data' => [
                                            'confirm' => 'Вы действительнос хотите пометить бан на пользователя '.$data->username.' ?',
                                            'method' => 'post',
                                        ]]).Html::a('Забанить', Url::to('/admin/user-mod/ban')."?id=".$data->id, ['class' => 'btn btn-outline-dark btn-block','data' => [
                                            'confirm' => 'Вы действительнос хотите забанить пользователя '.$data->username.'?',
                                            'method' => 'post',
                                        ]])."</div>";
                            }
                            else{
                                return "<div class='d-grid gap-2'>".Html::a('Разбанить', Url::to('/admin/user-mod/unban')."?id=".$data->id, ['class' => 'btn btn-outline-warning btn-block','data' => [
                                            'confirm' => 'Вы действительнос хотите разбанить пользователя '.$data->username.'?',
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
