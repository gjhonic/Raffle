<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\models\db\User;
use app\modules\admin\widget\StatusWidget;

/* @var $dataProvider \yii\db\ActiveRecord */
/* @var $searchModel \app\models\db\search\UserSearch */
/* @var $Statuses array */

$this->title = 'Модерация пользователей';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if(Yii::$app->user->identity->role_id == User::ROLE_ADMIN_ID){ ?>
        <p>
            <?php echo Html::a('Админский режим', Url::to('/admin/user-mod/admin'), ['class' => 'btn btn-outline-primary btn-block']); ?>
        </p>
    <?php } ?>

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
                    'filter' => StatusWidget::statusList(),
                    'value' => function ($data) {
                        return StatusWidget::statusLabel($data->status_id);
                    },
                    'format' => 'raw',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => "{view}",
                    'buttons' => [
                        'view' => function ($url,$data) {
                            return Html::a('Смотреть', Url::to('/admin/user/view')."?id=".$data->id, ['class' => 'btn btn-outline-success']);
                        },
                    ],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => "{update}",
                    'buttons' => [
                        'update' => function ($url,$data) {
                            if($data->status_id == 2){
                                return Html::a('Отметить бан', Url::to('/admin/user-mod/untag')."?id=".$data->id, ['class' => 'btn btn-outline-danger btn-block', 'data' => [
                                    'confirm' => 'Вы действительнос хотите отметить бан пользователя '.$data->username.'?',
                                    'method' => 'post',
                                ]]);
                            }elseif($data->status_id == 1){
                                return Html::a('Пометить бан', Url::to('/admin/user-mod/tag')."?id=".$data->id, ['class' => 'btn btn-outline-danger btn-block', 'data' => [
                                    'confirm' => 'Вы действительнос хотите пометить на бан пользователя '.$data->username.'?',
                                    'method' => 'post',
                                ]]);
                            }
                        },
                    ],
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
