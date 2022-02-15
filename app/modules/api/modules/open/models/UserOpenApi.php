<?php

namespace app\modules\api\modules\open\models;

use app\models\base\Raffle;
use Yii;
use yii\db\ActiveRecord;
use app\models\base\User;

class UserOpenApi extends User
{
    /**
     * Метод находит пользователя по его коду
     * @param string $code
     */
    public static function findByCodeApi(string $code)
    {
        return self::find()
            ->andWhere(['code' => $code])
            ->getUserByUserRole()
            ->getActiveUser()
            ->one();
    }

    /**
     * Метод пакует обьект пользователя в массив с нужным полями
     * @return array
     */
    public function getUserInArrayApi(): array
    {
        return [
            'code' => $this->code,
            'username' => $this->username,
            'name' => $this->name,
            'surname' => $this->surname,
        ];
    }

    /**
     * Метод возвращает коды конрусов пользователя
     * @return array
     */
    public function getCodesRafflesApi(): array
    {
        $raffles = Raffle::find()
            ->joinWith('user')
            ->getApprovedRaffle()
            ->andWhere(['user.code' => $this->code])
            ->all();

        $rafflesCode = [];

        foreach ($raffles as $raffle){
            $rafflesCode[] = [
                'code' => $raffle->code,
            ];
        }
        return $rafflesCode;
    }
}
