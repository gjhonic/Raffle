<?php

namespace app\models\base\validators;


use app\models\base\User;
use Yii;

class UserSettingsValidate
{
    //Возвращаемые ошибки
    public const SUCCESS_VALIDATE = 1;
    public const EMPTY_NAME = 2;
    public const EMPTY_SURNAME = 3;
    public const EMPTY_USERNAME = 4;
    public const EXIST_USERNAME = 5;
    public const EMPTY_CODE = 6;
    public const EXIST_CODE = 7;


    /**
     * Описание ошибок
     * @return array
     */
    public static function descriptionOfErrors(): array
    {
        return [
          self::EMPTY_NAME => Yii::t('app/error', 'Name field is empty'),
          self::EMPTY_SURNAME => Yii::t('app/error', 'Surname field is empty'),
          self::EMPTY_USERNAME => Yii::t('app/error', 'Username field is empty'),
          self::EXIST_USERNAME => Yii::t('app/error', 'This username is already taken'),
          self::EMPTY_CODE => Yii::t('app/error', 'Code field is empty'),
          self::EXIST_CODE => Yii::t('app/error', 'This code is already taken'),
        ];
    }

    /**
     * @param int $code
     * @return string
     */
    public static function getDescriptionError(int $code): string
    {
        return self::descriptionOfErrors()[$code];
    }

    /**
     * Метод валидации name
     * @param string $name
     * @return int
     */
    public static function validateName(string $name): int
    {
        if (trim($name) !== '') {
            return self::SUCCESS_VALIDATE;
        } else {
            return self::EMPTY_NAME;
        }
    }

    /**
     * Метод валидации surname
     * @param string $surname
     * @return int
     */
    public static function validateSurname(string $surname): int
    {
        if (trim($surname) !== '') {
            return self::SUCCESS_VALIDATE;
        } else {
            return self::EMPTY_SURNAME;
        }
    }

    /**
     * Метод валидации username
     * @param string $username
     * @return int
     */
    public static function validateUsername(string $username): int
    {
        if (trim($username) !== '') {
            $user = User::findByUsername($username);
            if ($user !== null) {
                if (Yii::$app->user->identity->username !== $username) {
                    //$this->addError($attribute, 'Данный username уже занят!');
                    return self::EXIST_USERNAME;
                }
                return self::SUCCESS_VALIDATE;
            }
            return self::SUCCESS_VALIDATE;
        } else {
            return self::EMPTY_USERNAME;
        }
    }

    /**
     * Метод валидации кода
     * @param string $code
     * @return int
     */
    public static function validateCode(string $code): int
    {
        if (trim($code) !== '') {
            $user = User::findByCode($code);
            if ($user !== null) {
                if (Yii::$app->user->identity->code !== $code) {
                    return self::EXIST_CODE;
                }
                return self::SUCCESS_VALIDATE;
            }
            return self::SUCCESS_VALIDATE;
        } else {
            return self::EMPTY_CODE;
        }
    }

    /**
     * Метод валидации about
     * @param string $about
     * @return int
     */
    public static function validateAbout(?string $about): int
    {
        return self::SUCCESS_VALIDATE;
    }
}