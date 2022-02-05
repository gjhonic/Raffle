<?php

namespace app\widgets;

use app\models\base\Raffle;
use Yii;

class RaffleStatusWidget
{
    private static function dataStatus(): array
    {
        return [
            1 => [
                'icon' => 'fa-check',
                'color' => 'green',
                'title' => Raffle::STATUS_APPROVED,
            ],
            2 => [
                'icon' => 'fa-question',
                'color' => 'orange',
                'title' => Raffle::STATUS_ON_CHECK,
            ],
            3 => [
                'icon' => 'fa-ban',
                'color' => 'red',
                'title' => Raffle::STATUS_NOT_APPROVED,
            ],
        ];
    }

    /**
     * Метод возвращает иконки стотуса конкуса
     * @param int $status_id
     * @return string
     */
    public static function getIcon(int $status_id): string
    {
        $class = self::dataStatus()[$status_id]['icon'];
        $title = self::dataStatus()[$status_id]['title'];

        return '<a class="icon solid ' . $class . '" title="' . Yii::t('app', $title) . '" style="color: #f56a6a"></a>';
    }

    /**
     * Метод возвразает цветной текстовый статус конкуса
     * @param int $status_id
     * @return string
     */
    public static function getLabel(int $status_id): string
    {
        $color = self::dataStatus()[$status_id]['color'];
        $title = self::dataStatus()[$status_id]['title'];

        return "<span style='color:" . $color . "'>" . Yii::t('app', $title) . "</span>";
    }
}