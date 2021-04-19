<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\models\db\User;


$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->identity->getRole() !== 'moderator')  { ?>
            <?= Html::a('Добавить пользователя', ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
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
                'role',


                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => "{view} {update}", //"{remove}",
                    'buttons' => [
                        'view' => function ($url,$model,$key) {
                            return Html::a('Смотреть', $url, ['class' => 'btn btn-outline-success btn-block']);
                        },

                        'update' => function ($url,$model,$key) {
                            return (Yii::$app->user->identity->getRole() !== User::ROLE_MODERATOR) ? Html::a('Изменить', $url, ['class' => 'btn btn-outline-primary btn-block']) : '';
                        },

                    ],
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>


</div>
