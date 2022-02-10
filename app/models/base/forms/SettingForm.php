<?php
/**
 * SettingForm
 * Форма настройки пользователя
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */

namespace app\models\base\forms;

use app\models\base\validators\UserSettingsValidate;
use common\models\ClientMessages;
use yii\base\Model;
use Yii;
use app\models\base\User;

/**
 * Class SettingForm
 * @package app\models\base\forms
 *
 * @property string $name
 * @property string $surname
 * @property string $code
 * @property string $username
 * @property string $about
 */
class SettingForm extends Model
{
    public $name;
    public $surname;
    public $about;
    public $code;
    public $username;
    public $vk_link;
    public $fb_link;
    public $ig_link;
    public $yt_link;

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'surname' => Yii::t('app', 'Surname'),
            'username' => Yii::t('app', 'Username'),
            'about' => Yii::t('app', 'About'),
            'code' => Yii::t('app', 'Code'),
        ];
    }

    public function saveSettings()
    {
        if ($this->validateInput()) {
            $user = User::findOne(Yii::$app->user->identity->getId());

            $transaction = Yii::$app->db->beginTransaction();

            $user->name = $this->name;
            $user->surname = $this->surname;
            $user->username = $this->username;
            $user->code = $this->code;
            if(!empty($this->about)){
                $user->setAbout($this->about);
            }

            if ($user->save(false)) {
                $transaction->commit();
            } else {
                $transaction->rollBack();
            }
        }
    }

    /**
     * Валидация полей
     * @return bool
     */
    private function validateInput(): bool
    {
        $resultValidateNameError = UserSettingsValidate::validateName($this->name);
        if ($resultValidateNameError !== UserSettingsValidate::SUCCESS_VALIDATE) {
            $this->addError('name', UserSettingsValidate::getDescriptionError($resultValidateNameError));
            return false;
        }

        $resultSurnameValidateError = UserSettingsValidate::validateSurname($this->surname);
        if ($resultSurnameValidateError !== UserSettingsValidate::SUCCESS_VALIDATE) {
            $this->addError('surname', UserSettingsValidate::getDescriptionError($resultSurnameValidateError));
            return false;
        }

        $resultUsernameValidateError = UserSettingsValidate::validateUsername($this->username);
        if ($resultUsernameValidateError !== UserSettingsValidate::SUCCESS_VALIDATE) {
            $this->addError('username', UserSettingsValidate::getDescriptionError($resultUsernameValidateError));
            return false;
        }

        $resultCodeValidateError = UserSettingsValidate::validateCode($this->code);
        if ($resultCodeValidateError !== UserSettingsValidate::SUCCESS_VALIDATE) {
            $this->addError('code', UserSettingsValidate::getDescriptionError($resultCodeValidateError));
            return false;
        }

        $resultAboutValidateError = UserSettingsValidate::validateAbout($this->about);
        if ($resultAboutValidateError !== UserSettingsValidate::SUCCESS_VALIDATE) {
            $this->addError('about', UserSettingsValidate::getDescriptionError($resultAboutValidateError));
            return false;
        }

        return true;
    }

    /**
     * __construct - Конструктор формы настроек, заполняет значения форм текущими данными
     */
    function __construct()
    {
        parent::__construct();

        $user = User::findOne(Yii::$app->user->identity->getId());
        if (isset($_POST['SettingForm'])) {
            $post = $_POST['SettingForm'];

            $userAbout = $user->getAboutInfo();

            $this->name = isset($post['name']) ? $post['name'] : $user->name;
            $this->surname = isset($post['surname']) ? $post['surname'] : $user->surname;
            $this->username = isset($post['username']) ? $post['username'] : $user->username;
            $this->code = isset($post['code']) ? $post['code'] : $user->code;
            $this->about = isset($post['about']) ? $post['about'] : $userAbout;
        } else {

            $userAbout = $user->getAboutInfo();

            $this->name = $user->name;
            $this->surname = $user->surname;
            $this->username = $user->username;
            $this->code = $user->code;
            $this->about = $userAbout;
        }
    }
}
