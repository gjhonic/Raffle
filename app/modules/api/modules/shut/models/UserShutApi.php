<?php

namespace app\modules\api\modules\shut\models;

use Yii;
use app\modules\api\models\UserApi;
use yii\db\ActiveRecord;


class UserShutApi extends UserApi
{
    /**
     * Метод возвращает конкурс по коду
     * @param string $code
     * @return array|ActiveRecord|null
     * @throws \yii\db\Exception
     */
    public static function findByCode($code, $field = false, $restrictions = ""){
        return parent::findByCode($code, self::accessField());
    }

    public static function accessField()
    {
        return "user.id AS id,
            user.code AS code,
            user.name AS name,
            user.surname AS surname,
            user.username AS username,
            user.status_id AS status_id,
            user.created_at AS created_at";
    }
}
