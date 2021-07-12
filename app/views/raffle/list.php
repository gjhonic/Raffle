<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\modules\admin\widget\RaffleStatusWidget;

/* @var $dataProvider \yii\db\ActiveRecord */
/* @var $user \app\models\db\User */

$this->title = 'Конкурсы от '.$user->username;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div style="overflow-x: auto;">
        <?php Pjax::begin(); ?>

        <?php

        if($user->id === Yii::$app->user->identity->getId() || (in_array(Yii::$app->user->identity->role_id, [User::ROLE_ADMIN_ID, User::ROLE_MODERATOR_ID]))){
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'title',
                    'date_begin',
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
                            'view' => function ($url, $model, $key) {
                                return Html::a('Смотреть', '/show/' . $model->code, ['class' => 'btn btn-outline-success btn-block']);
                            },
                        ],
                    ],
                ],
            ]);
        }else{
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'title',
                    'date_begin',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => "{view}",
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('Смотреть', '/show/' . $model->code, ['class' => 'btn btn-outline-success btn-block']);
                            },
                        ],
                    ],
                ],
            ]);
        }

        ?>

        <?php Pjax::end(); ?>
    </div>
</div>
