<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\admin\widget\RaffleStatusWidget;


$this->title = 'Конкурс: '.$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Конкурсы', 'url' => Url::to('/admin/raffle/')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="jumbotron">
        <h1 class="display-4">
            <?=$model->title?>
            <span style="font-size: 28px"><?=RaffleStatusWidget::statusLabel($model->status_id); ?></span>
        </h1>
        <p class="lead"><?=$model->short_description?></p>
        <p class="lead">
             <?=Html::a('Автор: '.$model->getUser()->username, URL::to('/admin/user/view').'?id='.$model->user_id, ['class' => 'btn btn-outline-success'])?>

        </p>
        <hr class="my-4">
        <p><?=$model->description?></p>
    </div>

</div>
