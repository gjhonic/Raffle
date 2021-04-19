<?php
/**
 * User
 * Класс для работы с записями пользователей
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com> 
*/

namespace app\models\db;

use Yii;
use yii\db\ActiveRecord;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\base\NotSupportedException;


class User extends ActiveRecord 
{
    
    /**
    * @var id - идентификатор первичный ключ
    * @var name - имя пользователя
    * @var surname - фамилия пользователя
    * @var patronymic - отчество пользователя (необяз)
    * @var username - логин пользователя
    * @var user_password - пароль пользователя
    * @var role - роль пользователя    
    */   
   
    /**
    * tableName - статическая функция. Возвращает название таблицы
    */
    public static function tableName(){

        return 'user';
    }

    //Роли системы
    const ROLE_ADMIN = "admin";
    const ROLE_MODERATOR = "moderator";
    const ROLE_USER = "user";
    const ROLE_GUEST = "?";

    /**
    * rules - метод которые устанавливает правила валидации
    */
    public function rules(){
        return [
            [['username', 'name', 'password', 'role', 'surname'], 'required'],
            [['username'], 'unique'],
            [['password'], 'myValidatePassword', 'skipOnEmpty'=> true],
            [['username'], 'myValidateUsername', 'skipOnEmpty'=> true],
            [['username', 'password'], 'string', 'max' => 255],
            [['name', 'surname', 'patronymic', 'role'], 'string', 'max' => 50],
            [['auth_key', 'access_token'], 'string', 'max' => 32],
        ];
    }

    /**
    * attributeLabels - метод которые устанавливает название атрибутам
    * @return Object - ассоциативный массив лэйблов
    */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'username' => 'Логин',
            'password' => 'Пароль',
            'role' => 'Роль',
        ];
    }


    // - - - Валидаторы - - -> 

    /**
     * validatePassword - метод валидации пароля,
     * @param $attribute, $params
     */
    // >> ------------------------------------------------- 
    public function myValidatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if(!trim($this->password)){
                //Notice::set('','Одни пробелы не являются паролем!','danger');
                $this->addError($attribute, 'Одни пробелы не являются паролем!');
            }else{
                if (strlen(trim($this->password)) <= 4 ){
                    //Notice::set('','Пароль должен быть больше 4 символов!','danger');
                    $this->addError($attribute, 'Пароль должен быть больше 4 символов!');
                }
            }
        } 
    }
    // ------------------------------------------------- <<

    /**
     * validatePassword - метод валидации пароля,
     * @param $attribute, $params
     */
    // >> -------------------------------------------------
    public function myValidateUsername($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if(!trim($this->username)){
                //Notice::set('','Одни пробелы не являются логином!','danger');
                $this->addError($attribute, 'Одни пробелы не являются логином!');
            }else{
                if (strlen(trim($this->username)) <= 3 ){
                    //Notice::set('','Логин должен быть больше 3 символов!','danger');
                    $this->addError($attribute, 'Логин должен быть больше 3 символов!');
                }
            }
        } 
    }
    // ------------------------------------------------- <<
    // <- - - 

    /**
     * getUsername - метод возвращает логин  юзера. 
     * @return string.
     */
    // >> -------------------------------------------------
    public function getUsername(){
        return $this->username;
    }
    // ------------------------------------------------- <<

    /**
     * getRole - метод возвращает роль пользователя
     * @return string
     */
    // >> -------------------------------------------------
    public function getRole(){
        return $this->role;
    }
    // ------------------------------------------------- <<

    /**
     * findUser - метод возвращает юpера по параметру поиска и возвращает данные без пароля. 
     * @param valueSearchParameter - Параметр поиска
     *        searchParameter - Название параметра поиска default = id
     * @return user - array.
     */
    // >> -------------------------------------------------
    public static function findUser($valueSearchParameter, $searchParameter='id'){
        return User::find()->select(['id','name', 'surname', 'username','type', 'patronymic'])->where([$searchParameter => $valueSearchParameter])->one();
    }
    // ------------------------------------------------- <<

    /**
     * getUser - метод возвращает юpера по параметру поиска. 
     * @param valueSearchParameter - Параметр поиска username/id
     *        searchParameter - Название параметра поиска default = id
     * @return user - array.
     */
    // >> -------------------------------------------------
    public static function getUser($valueSearchParameter, $searchParameter='id'){
        return User::find()->where([$searchParameter => $valueSearchParameter])->one();
    }
    // ------------------------------------------------- <<

    /**
     * exsistUsername - метод проверяет существует ли пользователь с таким логином 
     * @param username - string
     * @return bool
     */
    // >> -------------------------------------------------
    public static function exsistUsername($username){
        return (User::findUser($username, 'username')!=null) ? true : false;
    }
    // ------------------------------------------------- <<

    /**
     * exsistId - метод проверяет существует ли пользователь с таким id
     * @param username - string
     * @return bool
     */
    // >> -------------------------------------------------
    public static function exsistId($id){
        return (User::findUser($id)!=null) ? true : false;
    }
    // ------------------------------------------------- <<


    // - - - Методы сохранения данных - - - 
    /**
     * insertUser - Метод добавляет пользователя в систему и назначает RBAC роль
     */
    // >> ------------------------------------------------- 
    public function insertUser(){
        if($this->validate()){

            $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);

            if($this->save()){
                $auth = Yii::$app->authManager;

                $auth->assign($auth->getRole($this->role), $this->id);
                //Log::createLog('info', Yii::$app->user->identity->attributes['user_id'], 'Пользователь [id:'.$this->user_id.'] '.$this->user_username.' успешно создан!');
                return true;
            }
            else{
                //Log::createLog('error', Yii::$app->user->identity->attributes['user_id'], 'Произошла ошибка создания пользователя  '.$this->user_username.' !');
                return false;
            } 
        }
        
            
    }
    // ------------------------------------------------- <<

    /**
     * updateUser - Метод изменяет данные о пользователе
     */
    // >> -------------------------------------------------
    public function updateUser(){
        if($this->validate()) {
            if($this->update()){
                //Log::createLog('info', Yii::$app->user->identity->attributes['user_id'], 'Пользователь [id:'.$this->user_id.'] '.$this->user_username.' успешно обновлен!');
                return true;
            }
            else{
                //Log::createLog('error', Yii::$app->user->identity->attributes['user_id'], 'Произошла ошибка обновления пользователя  [id:'.$this->user_id.'] '.$this->user_username.'!');
                return false;
            } 
        }
    }
    // ------------------------------------------------- <<
    
    /**
     * updatePassword - Метод изменяет пароль пользователя
     */
    public function updatePassword(){
        if($this->validate()){

            $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);

            if($this->update()){
                //Log::createLog('info', Yii::$app->user->identity->attributes['user_id'], 'Пароль пользоватея [id:'.$this->user_id.'] '.$this->user_username.' успешно обновлен!');
                return true;
            }
            else{
                //Log::createLog('error', Yii::$app->user->identity->attributes['user_id'], 'Произошла ошибка обновления пароля пользователя  [id:'.$this->user_id.'] '.$this->user_username.'!');
                return false;
            } 
        }
    }
    // ------------------------------------------------- <<

    /**
     * updateRole - Метод изменяет роль пользователя
     */
    // >> -------------------------------------------------
    public function updateRole(){
        if($this->validate()){

            Yii::$app->authManager->revokeAll($this->role);
            Yii::$app->authManager->assign(Yii::$app->authManager->getRole($this->role), $this->id);

            if($this->update()){
                //Log::createLog('info', Yii::$app->user->identity->attributes['user_id'], 'Роль пользоватея [id:'.$this->user_id.'] '.$this->user_username.' успешно обновлена!');
                return true;
            }
            else{
                //Log::createLog('error', Yii::$app->user->identity->attributes['user_id'], 'Произошла ошибка обновления роли пользователя  [id:'.$this->user_id.'] '.$this->user_username.'!');
                return false;
            } 
        }
    }
    // ------------------------------------------------- <<

    /**
     * deleteUser - Метод удаляет пользователя из системы у очищает права
     */
    // >> -------------------------------------------------
    public function deleteUser(){
        $old_user_id = $this->id;
        $old_user_username = $this->username;

        if($this->delete()){
            Yii::$app->authManager->revokeAll($old_user_id);
            //Log::createLog('info', Yii::$app->user->identity->attributes['user_id'], 'Пользователь [id:'.$old_user_id.'] '.$old_user_username.' успешно удалена!');
            return true;
        }
        else{
            //Log::createLog('error', Yii::$app->user->identity->attributes['user_id'], 'Произошла ошибка удаления пользователя  [id:'.$this->old_user_id.'] '.$this->old_user_username.'!');
            return false;
        } 
    }
    // ------------------------------------------------- <<


}