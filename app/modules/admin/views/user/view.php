<?php

/* @var $model \app\models\base\User */

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use app\models\base\User;

$this->title = $model->surname . " " . $model->name . " (" . $model->username . ")";
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => Url::to('/admin/user/')];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if ($model->status_id === User::STATUS_TAG_TO_BAN_ID) { ?>

            <?= Html::a('Отметить бан', Url::to(['/admin/user-mod/untag', 'id' => $model->id]), [
                'class' => 'btn btn-outline-success btn-block',
                'data' => [
                    'confirm' => 'Вы действительнос хотите отметить бан пользователя ' . $model->username . '?',
                    'method' => 'post',
                ]]) ?>
            <?php if (Yii::$app->user->identity->role_id === User::ROLE_ADMIN_ID) { ?>
                <?= Html::a('Забанить', Url::to(['/admin/user-mod/ban', 'id' => $model->id]), [
                    'class' => 'btn btn-outline-dark btn-block',
                    'data' => [
                        'confirm' => 'Вы действительнос хотите забанить пользователя ' . $model->username . '?',
                        'method' => 'post',
                    ]]) ?>
            <?php } ?>
        <?php } elseif ($model->status_id === User::STATUS_ACTIVE_ID) { ?>
            <?= Html::a('Пометить бан', Url::to(['/admin/user-mod/tag', 'id' => $model->id]), [
                'class' => 'btn btn-outline-danger btn-block',
                'data' => [
                    'confirm' => 'Вы действительнос хотите пометить бан на пользователя ' . $model->username . ' ?',
                    'method' => 'post',
                ]]) ?>
            <?php if (Yii::$app->user->identity->role_id === User::ROLE_ADMIN_ID) { ?>
                <?= Html::a('Забанить', Url::to(['/admin/user-mod/ban', 'id' => $model->id]), [
                    'class' => 'btn btn-outline-dark btn-block',
                    'data' => [
                        'confirm' => 'Вы действительнос хотите забанить пользователя ' . $model->username . '?',
                        'method' => 'post',
                    ]]) ?>
            <?php } ?>
        <?php } elseif (Yii::$app->user->identity->role_id === User::ROLE_ADMIN_ID) { ?>
            <?= Html::a('Разбанить', Url::to(['/admin/user-mod/unban', 'id' => $model->id]), ['class' => 'btn btn-outline-warning btn-block', 'data' => [
                'confirm' => 'Вы действительнос хотите разбанить пользователя ' . $model->username . '?',
                'method' => 'post',
            ]]) ?>
        <?php } ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'code',
            'surname',
            'name',
            [
                'attribute' => 'role_id',
                'label' => 'Роль',
                'format' => 'raw',
                'value' => $model->role->title,

            ],
            [
                'attribute' => 'status_id',
                'label' => 'Статус',
                'format' => 'raw',
                'value' => $model->status->title,

            ],
        ],
    ]) ?>
</div>
