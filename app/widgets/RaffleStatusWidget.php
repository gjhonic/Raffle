<?php

namespace app\widgets;

use app\models\base\RaffleStatus;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class RaffleStatusWidget
{
    /**
     * Метод возвращает иконки стотуса конкуса
     * @param $status_id
     * @return string
     */
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
        return '<a class="icon solid '.$class.'" title="'.$title.'" style="color: #f56a6a"></a>';
    }

    /**
     * Метод возвразает цветной текстовый статус конкуса
     * @param $status_id
     * @return string
     */
    public static function getLabel($status_id): string
    {
        $color = "";
        $title = "";
        switch ($status_id) {
            case 3:
                $color = 'red';
                $title = "Запрещено!";
                break;
            case 2:
                $color = 'orange';
                $title = "На проверке!";
                break;
            case 1:
                $color = 'green';
                $title = "Опубликованно!";
                break;
        }
        return "<span style='color:".$color."'>$title</span>";
    }
}