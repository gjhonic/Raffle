<?php

namespace app\modules\admin\widgets;

use app\models\base\RaffleStatus;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class RaffleStatusWidget
{
    public static function statusList(): array
    {
        return ArrayHelper::map(RaffleStatus::find()->all(), 'id', 'title');
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case 3:
                $class = 'badge bg-danger';
                break;
            case 2:
                $class = 'badge bg-warning';
                break;
            case 1:
                $class = 'badge bg-success';
                break;
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}