<?php
/* @var $dataProvider */
/* @var $searchModel */

/* @var $Roles \app\models\base\UserRole */

use app\models\base\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->identity->role->title !== User::ROLE_MODERATOR) { ?>
            <?= Html::a('Добавить модератора', ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </p>

    <div style="overflow-x: auto;">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'username',
                'surname',
                'name',
                [
                    'attribute' => 'role_id',
                    'filter' => $Roles,
                    'label' => 'Роль',
                    'format' => 'text',
                    'content' => function ($data) {
                        return $data->role->title;
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => "{view}",
                    'buttons' => [
                        'view' => function ($url) {
                            return Html::a('Смотреть', $url, ['class' => 'btn btn-outline-success btn-block']);
                        },
                    ],
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>


</div>
