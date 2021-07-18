<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\models\db\User;
use app\widgets\RaffleStatusWidget;

/* @var $dataProvider \yii\db\ActiveRecord */
/* @var $user \app\models\db\User */

$this->title = 'Конкурсы от '.$user->username;
//TODO в array columns формировать отдельно
?>
<div class="user-index">

    <h1>Конкурсы от <?=Html::a($user->username, '/profile/' . $user->code, ['class' => '']);?></h1>

    <div style="overflow-x: auto;">
        <?php Pjax::begin(); ?>

        <?php

        if($user->id === Yii::$app->user->identity->getId() || (in_array(Yii::$app->user->identity->role_id, [User::ROLE_ADMIN_ID, User::ROLE_MODERATOR_ID]))){
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'title',
                    ],
                    [
                        'attribute' => 'date_begin',
                    ],
                    [
                        'attribute' => 'status_id',
                        'value' => function ($data) {
                            return RaffleStatusWidget::getLabel($data->status_id);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => "{view}",
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('Смотреть', '/show/' . $model->code, ['class' => 'button']);
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
                                return Html::a('Смотреть', '/show/' . $model->code, ['class' => 'button']);
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
