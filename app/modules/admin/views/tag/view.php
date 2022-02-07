<?php

use app\modules\admin\widgets\RaffleStatusWidget;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $model object */
/* @var $dataProviderRaffles \yii\db\ActiveRecord */
/* @var $searchModelRaffles \app\models\base\search\UserSearch */

$this->title = "Тег: ".$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Теги', 'url' => Url::to('/admin/tag/')];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-outline-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить тег: '.$model->title.'?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title'
        ],
    ]) ?>

    <br>

    <h3>Конкурсы с тегом <?= $this->title ?></h3>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProviderRaffles,
        'filterModel'  => $searchModelRaffles,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            [
                'attribute' => 'status_id',
                'filter' => RaffleStatusWidget::statusList(),
                'value' => function ($data) {
                    return RaffleStatusWidget::statusLabel($data->status_id);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'user_id',
                'value' => function ($data) {
                    $user = $data->user;
                    if($user){
                        return "<a href='" . Url::to(['/admin/user/view', 'id' => $user->id]) . "'>".$user->username."</a>";
                    }

                },
                'format' => 'raw',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view}",
                'buttons' => [
                    'view' => function ($url,$model,$key) {
                        return Html::a('Смотреть', Url::to(['raffle/view', 'id' => $model->id]), ['class' => 'btn btn-outline-success btn-block']);
                    },
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
