<?php
/**
 * UserIdentity
 * Класс для аутентифицированного пользователя
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */

namespace app\models\auth;

use app\models\base\UserRole;
use Yii;
use yii\web\IdentityInterface;
use app\models\base\User;

/**
 * Class UserIdentity
 * @package app\models\auth
 *
 * FROM USER
 * @property UserRole $role
 * @property int $role_id
 */
class UserIdentity extends User implements IdentityInterface
{

    /**
     * Метод возвращает пользователя по его id
     * @param int|string $id
     * @return UserIdentity|IdentityInterface|null
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * Метод возвращает пользователя по его access_token
     * @param mixed $token
     * @param null $type
     * @return UserIdentity|IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Метод возвращает пользователя по его username
     * @param string $username
     * @return UserIdentity|array|\yii\db\ActiveRecord|null
     */
    public static function findByUsername(string $username): ?User
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Метод возвращает id пользователя
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Метод возвращает код пользователя
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Метод возвращает авторизационный ключ юзера
     * @return string|null
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Метод возвращает авторизационный ключ юзера
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Метод валидации паролей
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Метод возвращает текущего пользователя в системе
     * @return mixed
     */
    public static function currentUser()
    {
        return parent::findUser(Yii::$app->user->identity->attributes['id']);
    }

    /**
     * Метод возвращает id текущего пользователя в системе
     * @return mixed
     */
    public static function IdCurrentUser()
    {
        return Yii::$app->user->identity->attributes['id'];
    }
}