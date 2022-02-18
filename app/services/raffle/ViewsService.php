<?php

namespace app\services\raffle;

use app\models\base\Address;
use app\models\base\RaffleView;

class ViewsService
{

    /**
     * Метод добаляет просмотр на конкурс.
     * @param string $ipAddress
     * @param int $raffle_id
     */
    public static function setView(string $ipAddress, int $raffle_id): bool
    {
        $address = Address::getAddress($ipAddress);

        $raffleView = RaffleView::findOne([
            'address_id' => $address->id,
            'raffle_id' => $raffle_id,
        ]);
        if (!$raffleView) {
            return self::addView($address->id, $raffle_id);
        }
        return true;
    }

    /**
     * @param int $address_id
     * @param int $raffle_id
     * @return bool
     */
    private static function addView(int $address_id, int $raffle_id): bool
    {
        $raffleView = new RaffleView();
        $raffleView->address_id = $address_id;
        $raffleView->raffle_id = $raffle_id;
        return $raffleView->save();
    }
}