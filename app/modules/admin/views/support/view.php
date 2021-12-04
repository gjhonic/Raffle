<?php

use app\models\base\Support;
use app\modules\admin\widgets\SuportStatusWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model object */

$this->title = "Обращение №: ".$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Обращения', 'url' => Url::to('/admin/support-mod/index')];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="support-view">
    <h1>
        <?= Html::encode($this->title) ?>
        <span style="font-size: 28px"><?=SuportStatusWidget::statusLabel($model->status); ?></span>
    </h1>

    <p>
        <?php if($model->status === Support::STATUS_VIEWED) { ?>
            <?= Html::a('Пометить', ['/admin/support-mod/tag', 'id' => $model->id], [
                'class' => 'btn btn-outline-warning',
                'data' => [
                    'confirm' => 'Вы действительно хотите пометить как ВАЖНОЕ обращение: '.$model->title.'?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php } if($model->status === Support::STATUS_IMPORTANT) {?>
            <?= Html::a('Снять метку', ['/admin/support-mod/untag', 'id' => $model->id], [
                'class' => 'btn btn-outline-warning',
                'data' => [
                    'confirm' => 'Вы действительно хотите отменить метку на обращение: '.$model->title.'?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php }?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-outline-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить обращение: '.$model->title.'?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="jumbotron">
        <h1 class="display-4">
            <?=$model->title?>
        </h1>
        <p>
            Дата создания: <b><?=date('j F, Y H:i:s', $model->created_at)?></b>
        </p>

        <p class="lead">
            <?=Html::a('Автор: '.$model->user->username, Url::to('/admin/user/view').'?id='.$model->user_id, ['class' => 'btn btn-outline-secondary'])?>

        </p>
        <hr class="my-4">
        <p><?=$model->description?></p>
    </div>
</div>
