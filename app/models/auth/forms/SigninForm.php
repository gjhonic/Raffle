<?php
/**
 * SigninForm
 * Форма аутентификации
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */
namespace app\models\auth\forms;

use Yii;
use yii\base\Model;
use app\models\auth\UserIdentity;

class SigninForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Метод валидации пароля.
     * @param $attribute, $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Метод заполняем свойство _user  обьектом user, если он не заполнен и возвращает его.
     * @return object - user.
     */
    public function getUser(): object
    {
        if ($this->_user === false) {
            $this->_user = UserIdentity::findByUsername($this->username);
        }
        return $this->_user;
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'rememberMe' => Yii::t('app', 'Remember me'),
        ];
    }
}
