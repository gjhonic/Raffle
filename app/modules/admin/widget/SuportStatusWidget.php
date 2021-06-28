<?php

namespace app\modules\admin\widget;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class SuportStatusWidget
{
    public static function statusList(): array
    {
        return [
            0 => 'Не просмотрено',
            1 => 'Просмотрено',
            2 => 'Важно'
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case 0:
                $class = 'badge bg-warning';
                break;
            case 1:
                $class = 'badge bg-success';
                break;
            case 2:
                $class = 'badge bg-danger';
                break;
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}