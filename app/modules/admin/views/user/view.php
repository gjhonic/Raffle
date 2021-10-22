<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

$this->title = $model->surname." ".$model->name." (".$model->username.")";
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => Url::to('/admin/user/')];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

          <?php if (Yii::$app->user->identity->getRole()->title === 'root') { ?>
            <?= ModelWindow::render("Удалить", "Подтвердите действие", '?r=sevand/core/user/remove&id='.$model->id ,"Вы точно хотите удалить пользователя (<i>".$model->user_username. "</i>) <b> ".$model->user_surname." ".$model->user_name."</b> ?", "btn btn-outline-danger", "btn btn-warning") ?>
          <?php } ?>


    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'surname',
            'name',
            [
                'attribute'=>'role_id',
                'label' => 'Роль',
                'format' => 'raw',
                'value'=> $model->getRole()->title,

            ],
            [
                'attribute'=>'status_id',
                'label' => 'Статус',
                'format' => 'raw',
                'value'=> $model->getStatus()->title,

            ],
        ],
    ]) ?>



</div>
