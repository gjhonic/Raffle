<?php
/**
 * SettingForm
 * Форма настройки пользователя
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */
namespace app\models\base\forms;

use yii\base\Model;
use Yii;
use app\models\base\Raffle;
use app\models\base\User;

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
     * Метод валидации name
     * @param $attribute
     */
    private function validateName($attribute = 'name'): bool
    {
        if (trim($this->name) !== ''){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Метод валидации surname
     * @param $attribute
     */
    private function validateSurname($attribute = 'surname'): bool
    {
        if (trim($this->surname) !== ''){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Метод валидации кода
     * @param $attribute
     */
    private function validateUniqueCode($attribute = 'code'): bool
    {
        if (trim($this->code) !== '') {
            $user = User::findByCode($this->code);
            if ($user!== null){
                if(Yii::$app->user->identity->code !== $this->code){
                    $this->code = Yii::$app->user->identity->code;
                    $this->addError($attribute, 'Данный код уже занят!');
                    return false;
                }
                return true;
            }
            return true;
        }else{
            return false;
        }
    }

    /**
     * Метод валидации username
     * @param $attribute
     * @return bool
     */
    private function validateUniqueUsername($attribute = 'username'): bool
    {
        if (trim($this->username) !== '') {
            $user = User::findByUsername($this->username);
            if ($user!== null){
                if(Yii::$app->user->identity->username !== $this->username){
                    $this->username = Yii::$app->user->identity->username;
                    $this->addError($attribute, 'Данный username уже занят!');
                    return false;
                }
                return true;
            }
            return true;
        }else{
            return false;
        }
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'about' => 'Обо мне',
            'code' => 'Код',
        ];
    }

    public function saveSettings()
    {
        $user = User::findOne(Yii::$app->user->identity->getId());
        $isChange = false;

        if($this->validateName()){
            $isChange = true;
            $user->name = $this->name;
        }

        if($this->validateSurname()){
            $isChange = true;
            $user->surname = $this->surname;
        }

        if($this->validateUniqueUsername()){
            $isChange = true;
            $user->username = $this->username;
        }

        if($this->validateUniqueCode()){
            $isChange = true;
            $user->code = $this->code;
        }

        if($isChange){
            return $user->update();
        }
    }

    /**
     * __construct - Конструктор формы настроек, заполняет значения форм текущими данными
     */
    function __construct() {
        parent::__construct();

        $user = User::findOne(Yii::$app->user->identity->getId());
        if(isset($_POST['SettingForm'])){
            $post = $_POST['SettingForm'];

            $this->name = isset($post['name']) ? $post['name'] : $user->name;
            $this->surname = isset($post['surname']) ? $post['surname'] : $user->surname;
            $this->username = isset($post['username']) ? $post['username'] : $user->username;
            $this->code = isset($post['code']) ? $post['code'] : $user->code;
        }else{
            $this->name = $user->name;
            $this->surname = $user->surname;
            $this->username = $user->username;
            $this->code  = $user->code;
        }
    }
}
