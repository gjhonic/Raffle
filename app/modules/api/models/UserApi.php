<?php

namespace app\modules\api\models;

use Yii;
use app\models\db\User;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $username
 * @property string $email
 * @property string $email_confirm
 * @property string $password
 * @property int $role_id
 * @property int $status_id
 * @property string $code
 * @property string|null $auth_key
 * @property string|null $access_token
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Post[] $posts
 * @property Raffle[] $raffles
 * @property UserRole $role
 * @property UserStatus $status
 * @property UserOtherInfo[] $userOtherInfos
 */
class UserApi extends \yii\db\ActiveRecord
{
    /**
     * Метод возвращает пользователя по коду
     * @param string $code - уникальный код конкурса
     * @param string $field - возвращаемые поля
     * @return array|ActiveRecord|null
     * @throws \yii\db\Exception
     */
    public static function findByCode($code, $field, $addCond= ""){
        $placeholders = [
            'user_code' => $code,
        ];
        $sql = "SELECT ".$field."
         FROM user
         WHERE user.code = :user_code
         $addCond";
        return Yii::$app->db->createCommand($sql, $placeholders)->queryOne();
    }

    /**
     * Метод возвращает количество подписчиков пользователя
     * @param string $code - уникальный код конкурса
     * @param string $field - возвращаемые поля
     * @return array|ActiveRecord|null
     * @throws \yii\db\Exception
     */
    public static function getCountSubscribers($code){
        $placeholders = [
            'user_code' => $code,
        ];
        $sql = "SELECT COUNT(subscriptions.subscriber_id) AS count
         FROM subscriptions
         LEFT JOIN user ON user.code = :user_code
         WHERE subscriptions.user_id = user.id";
        return Yii::$app->db->createCommand($sql, $placeholders)->queryOne();
    }

    /**
     * Метод возвращает количество подписок пользователя
     * @param string $code - уникальный код конкурса
     * @param string $field - возвращаемые поля
     * @return array|ActiveRecord|null
     * @throws \yii\db\Exception
     */
    public static function getCountSubscriptions($code){
        $placeholders = [
            'user_code' => $code,
        ];
        $sql = "SELECT COUNT(subscriptions.user_id) AS count
         FROM subscriptions
         LEFT JOIN user ON user.code = :user_code
         WHERE subscriptions.subscriber_id = user.id";
        return Yii::$app->db->createCommand($sql, $placeholders)->queryOne();
    }
}
