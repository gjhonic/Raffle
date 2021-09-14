<?php

namespace app\modules\api\modules\open\models;

use Yii;
use app\modules\api\models\UserApi;
use yii\db\ActiveRecord;
use app\models\db\User;

class UserOpenApi extends UserApi
{
    /**
     * Метод возвращает конкурс по коду
     * @param string $code
     * @return array|ActiveRecord|null
     * @throws \yii\db\Exception
     */
    public static function findByCode($code, $field = false, $addCond = ""){
        return parent::findByCode($code, self::accessField(), self::addCond());
    }

    public static function accessField()
    {
        return "user.code AS code,
            user.name AS name,
            user.surname AS surname,
            user.username AS username";
    }

    public static function addCond()
    {
        return "AND user.status_id <> ".User::STATUS_BAN_ID;
    }
}
