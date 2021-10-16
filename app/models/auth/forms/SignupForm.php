<?php
/**
 * SignupForm
 * Форма регистрации
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */
namespace app\models\auth\forms;

use Yii;
use yii\base\Model;
use app\models\auth\UserIdentity;
use app\models\db\User;


class SignupForm extends Model
{

    public $name;
    public $surname;
    public $password;
    public $email;
    public $password_confirm;
    public $username;

    public $user;

    /**
     * rules - метод возвращает правила валидации.
     * @return array - правила валидации.
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'username', 'password', 'password_confirm', 'email'], 'required'],
            ['username', 'validateUsername'],
            ['email', 'email'],
            ['email', 'validateEmail'],
            ['password', 'validatePassword'],
            ['password_confirm', 'validatePasswordConfirm']
        ];
    }

    /**
     * Метод валидации логина.
     * @param $attribute, $params
     */
    public function validateUsername($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findbyUsername($this->username);

            if ($user) {
                $this->addError($attribute, 'Данный логин занят');
            }
        }
    }

    /**
     * Метод валидации почты.
     * @param $attribute, $params
     */
    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findByEmail($this->email);

            if ($user) {
                $this->addError($attribute, 'Почта занята');
            }
        }
    }

    /**
     * Метод валидации пароля.
     * @param $attribute, $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if(strlen(trim($this->password)) <= 5){
                $this->addError($attribute, 'Пароль долже быть больше 5 символов');
            }
        }
    }

    /**
     * Метод валидации сходства паролей.
     * @param $attribute, $params
     */
    public function validatePasswordConfirm($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if($this->password != $this->password_confirm){
                $this->addError($attribute, 'Пароли не совпадают');
            }
        }
    }

    /**
     * Метод "регает" юзера в бд.
     * @return bool.
     */
    public function signup()
    {
        if($this->validate()){

            $user = new User();
            $user->name = $this->name;
            $user->surname = $this->surname;
            $user->username = $this->username;
            $user->email = $this->email;
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            $user->role_id = 3;
            $user->status_id = 1;
            $user->code = $this->username;
            $user->email_confirm = 0;

            if ($user->save()){
                Yii::$app->authManager->assign(Yii::$app->authManager->getRole(User::ROLE_USER), $user->id);
                $this->user = $user;
                return true;
            }else{
                return false;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'username' => 'Логин',
            'email' => 'Почта',
            'password' => 'Пароль',
            'password_confirm' => 'Подтвердите пароль',
        ];
    }

}
