<?php
/**
 * SettingsPasswordForm
 * Форма настройки пароля пользователя
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */
namespace app\models\db\forms;

use yii\base\Model;
use Yii;
use app\models\db\User;

class SettingPasswordForm extends Model
{
    public $password_old;
    public $password_new;
    public $password_new_confirm;

    /**
     * Метод валидации поля текущего пароля
     * @param $attribute
     */
    private function checkPassword($attribute = 'password_old'): bool
    {
        return true;
    }

    /**
     * Метод валидации surname
     * @param $attribute
     */
    private function validateIqualNewPassword($attribute = 'password_new_confirm'): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'password_old' => 'Текущий пароль',
            'password_new' => 'Новый пароль',
            'password_new_confirm' => 'Подтвердите пароль',
        ];
    }

    public function saveSettings()
    {

    }

    /**
     * __construct - Конструктор формы настроек, заполняет значения форм текущими данными
     */
    function __construct() {
        parent::__construct();

    }
}
