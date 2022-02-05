<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\base\User;
use app\widgets\RaffleStatusWidget;

/* @var $dataProvider \yii\db\ActiveRecord */
/* @var $user \app\models\base\User */

$this->title = Yii::t('app', 'Raffles from') . ' ' . $user->username;
?>
<div class="raffle-list">

    <h1>
        <?= Yii::t('app', 'Raffles from') ?>
        <?= Html::a($user->username, '/profile/' . $user->code, ['class' => '']); ?>
    </h1>

    <div style="overflow-x: auto;">
        <?php Pjax::begin();

        if ($user->id === Yii::$app->user->identity->getId() || (in_array(Yii::$app->user->identity->role_id, [User::ROLE_ADMIN_ID, User::ROLE_MODERATOR_ID]))) {
            $columns = [
                ['class' => 'yii\grid\SerialColumn'],
                'title',
                'date_begin',
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
                        'view' => function ($url, $model) {
                            return Html::a(Yii::t('app', 'Show'), '/show/' . $model->code, ['class' => 'button fit']);
                        },
                    ],
                ],
            ];
        } else {
            $columns = [
                ['class' => 'yii\grid\SerialColumn'],
                'title',
                'date_begin',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => "{view}",
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a(Yii::t('app', 'Show'), '/show/' . $model->code, ['class' => 'button']);
                        },
                    ],
                ],
            ];
        } ?>

        <?=GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'tableOptions' => [
                'class' => 'alt'
            ],
            'columns' => $columns,
        ]); ?>

        <?php Pjax::end(); ?>
    </div>
</div>
