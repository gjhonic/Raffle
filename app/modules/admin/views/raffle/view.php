<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\admin\widgets\RaffleStatusWidget;
use app\models\base\Raffle;

/* @var $model object */

$this->title = 'Конкурс: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Конкурсы', 'url' => Url::to('/admin/raffle/')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="raffle-view">

    <div class="jumbotron">
        <h1 class="display-4">
            <?= $model->title ?>
            <span style="font-size: 28px"><?= RaffleStatusWidget::statusLabel($model->status_id); ?></span>
        </h1>
        <p class="lead"><?= $model->short_description ?></p>
        <p>
            Дата создания: <b><?= date('j F, Y H:i:s', $model->created_at) ?></b>
        </p>
        <p>
            Дата обновления:<b> <?= date('j F, Y H:i:s', $model->updated_at) ?></b>
        </p>

        <p>
            Код:<b> <?= $model->code ?></b>
        </p>

        <p class="lead">
            <?= Html::a('Автор: ' . $model->user->username, Url::to(['/admin/user/view', 'id' => $model->user_id]), ['class' => 'btn btn-outline-secondary']) ?>
        </p>

        <p>
            <?php if ($model->status_id == Raffle::STATUS_APPROVED_ID) { ?>
                <?= Html::a('Запретить', Url::to(['/admin/raffle-mod/ban', 'id' => $model->id]), ['class' => 'btn btn-outline-danger']) ?>
            <?php } elseif ($model->status_id == Raffle::STATUS_ON_CHECK_ID) { ?>
                <?= Html::a('Одобрить', Url::to(['/admin/raffle-mod/unban', 'id' => $model->id]), ['class' => 'btn btn-outline-success']) ?>
                <?= Html::a('Запретить', Url::to(['/admin/raffle-mod/ban', 'id' => $model->id]), ['class' => 'btn btn-outline-danger']) ?>
            <?php } elseif ($model->status_id == Raffle::STATUS_NOT_APPROVED_ID) { ?>
                <?= Html::a('Одобрить', Url::to(['/admin/raffle-mod/unban', 'id' => $model->id]), ['class' => 'btn btn-outline-success']) ?>
            <?php } ?>
        </p>

        <p>
        <h4>Теги:</h4>
        <?php foreach ($model->tags as $tag) { ?>
            <?= Html::a($tag->title, Url::to(['/admin/tag/view', 'id' => $tag->id]), ['class' => 'btn btn-outline-secondary']) ?>
        <?php } ?>
        </p>

        <hr class="my-4">
        <p><?= $model->description ?></p>
    </div>

</div>
