<?php

namespace app\modules\api\modules\open\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\base\User;

class UserOpenApi extends User
{
    /**
     * Метод возвращает конкурс по коду
     * @param string $code
     * @throws \yii\db\Exception
     */
    public static function findByCodeApi(string $code): array
    {
        $user = User::find()
            ->andWhere(['code' => $code])
            ->getUserByUserRole()
            ->getActiveUser()
            ->one();

        $userArray = [];
        if ($user) {
            $userArray = [
                'code' => $user->code,
                'username' => $user->username,
                'name' => $user->name,
                'surname' => $user->surname,
            ];
        }
        return $userArray;
    }
}
