<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\modules\admin\widgets\SuportStatusWidget;

/* @var $dataProvider \yii\db\ActiveRecord */
/* @var $searchModel \app\models\base\search\UserSearch */
/* @var $Statuses array */

$this->title = 'Модерация обращений';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div style="overflow-x: auto;">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'title',
                [
                    'attribute' => 'user_id',
                    'value' => function ($data) {
                        $user = $data->getUser();
                        return "<a href='".URL::to('/admin/user/view')."?id=".$user->id."'>".$user->username."</a>";
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'status',
                    'filter' => SuportStatusWidget::statusList(),
                    'value' => function ($data) {
                        return SuportStatusWidget::statusLabel($data->status);
                    },
                    'format' => 'raw',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => "{view}",
                    'buttons' => [
                        'view' => function ($url,$data) {
                            return "<div class='d-grid gap-2'>".Html::a('Смотреть', Url::to('/admin/support/view').'?id='.$data->id, ['class' => 'btn btn-outline-primary'])."</div>";
                        },
                    ],
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
