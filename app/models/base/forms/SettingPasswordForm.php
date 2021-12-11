<?php
/**
 * SettingsPasswordForm
 * Форма настройки пароля пользователя
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */
namespace app\models\base\forms;

use yii\base\Model;
use Yii;
use app\models\base\User;

class SettingPasswordForm extends Model
{
    public $password_old;
    public $password_new;
    public $password_new_confirm;

    /**
     * Метод валидации поля паролей
     * @param $attribute
     */
    private function validatePassword()
    {
        $error = false;
        if (trim($this->password_old) == '') {
            $error = true;
        }
        if (trim($this->password_new) == '') {
            $error = true;
        }
        if (trim($this->password_new_confirm) == '') {
            $error = true;
        }

        return !$error;
    }

    /**
     * Метод валидации поля текущего пароля
     * @param $attribute
     * @return bool
     */
    private function checkPassword($attribute = 'password_old'): bool
    {
        $password = Yii::$app->user->identity->password;
        if(Yii::$app->getSecurity()->validatePassword($this->password_old, $password)){
            return true;
        }else{
            $this->addError($attribute, 'Не верный пароль!');
            $this->clearField();
            return false;
        }
    }

    /**
     * Метод валидации нового пароля
     * @param $attribute
     * @return bool
     */
    private function validateNewPassword($attribute = 'password_new'): bool
    {
        if (!$this->hasErrors()) {
            if(!trim($this->password_new)){
                $this->addError($attribute, 'Одни пробелы не являются паролем!');
                return false;
            }else if(strlen(trim($this->password_new)) <= 5){
                $this->addError($attribute, 'Пароль должен быть больше 5 символов!');
                return false;
            }else{
                return true;
            }
        }
    }

    /**
     * Метод валидации схожести паролей
     * @param $attribute
     */
    private function validateEquallyNewPassword($attribute = 'password_new_confirm'): bool
    {
        if($this->password_new === $this->password_new_confirm){
            return true;
        }else{
            $this->addError($attribute, 'Пароли не совпадают');
            return false;
        }
    }

    /**
     * Метод валидации схожести паролей
     */
    private function clearField(): void
    {
        $this->password_old = '';
        $this->password_new = '';
        $this->password_new_confirm = '';
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'password_old' => Yii::t('app', 'Current Password'),
            'password_new' => Yii::t('app', 'New password'),
            'password_new_confirm' => Yii::t('app', 'Confirm the password'),
        ];
    }

    /**
     * Метод сохранения пароля
     * @return false|int
     * @throws \Throwable
     * @throws \yii\base\Exception
     * @throws \yii\db\StaleObjectException
     */
    private function changePassword()
    {
        if($this->validatePassword()){
            if($this->checkPassword() && $this->validateNewPassword() && $this->validateEquallyNewPassword()){
                $user = User::findOne(Yii::$app->user->identity->getId());
                $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password_new);
                return $user->update();
            }
        }
    }

    public function saveSettings()
    {
        return $this->changePassword();
    }

    /**
     * __construct - Конструктор формы настроек, заполняет значения форм текущими данными
     */
    function __construct() {
        parent::__construct();

        if(isset($_POST['SettingPasswordForm'])){
            $post = $_POST['SettingPasswordForm'];
            $this->password_old = isset($post['password_old']) ? $post['password_old'] : '';
            $this->password_new = isset($post['password_new']) ? $post['password_new'] : '';
            $this->password_new_confirm = isset($post['password_new_confirm']) ? $post['password_new_confirm'] : '';
        }else{
            $this->password_old = '';
            $this->password_new = '';
            $this->password_new_confirm = '';
        }
    }
}
