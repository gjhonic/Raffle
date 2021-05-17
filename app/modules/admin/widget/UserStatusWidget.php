<?php

namespace app\modules\admin\widget;

use app\models\db\UserStatus;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class UserStatusWidget
{
    public static function statusList(): array
    {
        return ArrayHelper::map(UserStatus::find()->all(), 'id', 'title');
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