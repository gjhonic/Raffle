<?php

use app\modules\api\models\MethodsApi;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel \app\modules\api\models\search\ActionApiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Логи использования Api';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="direction-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="content">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'method',
                    'filter' => MethodsApi::getMethodsMap(),
                ],
                [
                    'attribute' => 'version',
                    'filter' => MethodsApi::getVersionMap(),
                ],
                [
                    'attribute' => 'address',
                    'label' => 'Адресс',
                    'value' => function ($model) {
                        return $model->address->ip;
                    }
                ],
                [
                    'label' => 'Время использования',
                    'value' => function ($model) {
                        return date('Y-m-d H:i:s', $model->created_at);
                    }
                ]
            ],
        ]); ?>
    </div>

</div>
