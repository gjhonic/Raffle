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


class SignupForm extends Model
{

    public $name;
    public $surname;
    public $patronymic;
    public $password;
    public $password_confirm;
    public $username;

    /**
     * rules - метод возвращает правила валидации.
     * @return array - правила валидации.
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'username', 'password', 'password_confirm'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * validatePassword - метод валидации пароля.
     * @param $attribute, $params
     */
    // >> -------------------------------------------------
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }
    // ------------------------------------------------- <<

    /**
     * login - метод "регает" юзера в бд.
     * @return bool.
     */
    // >> -------------------------------------------------
    public function signup()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }else{
            return false;
        }
    }
    // ------------------------------------------------- <<

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'username' => 'Логин',
            'password' => 'Пароль',
            'password_confirm' => 'Подтвердите пароль',
        ];
    }



}
