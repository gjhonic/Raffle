<?php
/**
 * UserIdentity 
 * Класс для аутентифицированного пользователя
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com> 
*/
namespace app\models\auth;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\models\db\User;

class UserIdentity extends User implements IdentityInterface
{

    /**
     * findIdentity - метод возвращает юзера по его id. 
     * @param id - идентификатор первичный ключ юзера.
     * @return user - полученная модель юзера.
     */
    public static function findIdentity($id){
        return static::findOne(['id' => $id]);
    }
    
    /**
     * findIdentityByAccessToken - метод возвращает юзера по его access_token. 
     * @param $token - access token user.
     * @return user - полученная модель юзера.
     */
    public static function findIdentityByAccessToken($token, $type = null){
        return static::findOne(['access_token' => $token]);
    }

    /**
     * findByUsername - метод возвращает юзера по его username. 
     * @param $username - логин пользователя.
     * @return user - полученная модель юзера.
     */
    public static function findByUsername($username){
        return static::findOne(['username' => $username]);
    }

    /**
     * getId - метод возвращает id юзера. 
     * @return int - первичный ключ юзера.
     */
    public function getId(){
        return $this->id;
    }

     /**
     * getAuthKey - метод возвращает авторизационный ключ юзера. 
     * @return _auth_key - авторизационный ключ.
     */
    public function getAuthKey(){
        return $this->auth_key;
    }

    /**
     * validateAuthKey - метод сопоставляет ключи авторизации.
     * @param authKey ключ авторизации
     * @return bool - результат сравнения ключей авторизации.
     */
    public function validateAuthKey($authKey){
        return $this->auth_key === $authKey;
    }

    /**
     * validatePassword - метод валидации паролей.
     * @param password - пароль из вне(форма).
     * @return bool - результат сравнения паролей.
     */
    public function validatePassword($password){
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * currentUser - возвращает текущего пользователя в системе
     * @return obj.
     */
    public static function currentUser(){
        return parent::findUser(Yii::$app->user->identity->attributes['id']);
    }

    /**
     * IdCurrentUser - возвращает id текущего пользователя в системе
     * @return int.
     */
    public static function IdCurrentUser(){
        return Yii::$app->user->identity->attributes['id'];
    }
    
    

}