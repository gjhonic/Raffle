<?php

namespace app\widgets;

use app\models\db\RaffleStatus;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class RaffleStatusWidget
{
    public static function getIcon($status_id): string
    {
        $class = "";
        $title = "";
        switch ($status_id) {
            case 3:
                $class = 'fa-ban';
                $title = "Запрещено!";
                break;
            case 2:
                $class = 'fa-question';
                $title = "На проверке!";
                break;
            case 1:
                $class = 'fa-check';
                $title = "Опубликованно!";
                break;
        }
        return '<a class="icon solid '.$class.'" title="'.$title.'"></a>';
    }

}