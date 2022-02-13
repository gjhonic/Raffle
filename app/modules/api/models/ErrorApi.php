<?php


namespace app\modules\api\models;


use Yii;

class ErrorApi
{
    const ERROR_EMPTY_CODE_RAFFLE = 1;
    const ERROR_RAFFLE_NOT_FOUND = 2;

    /**
     * Описание ошибок
     * @return array
     */
    public static function descriptionOfErrors(): array
    {
        return [
            self::ERROR_EMPTY_CODE_RAFFLE => Yii::t('app/error', 'Raffle code parameter not specified'),
            self::ERROR_RAFFLE_NOT_FOUND => Yii::t('app/error', 'Raffle not found'),
        ];
    }

    /**
     * @param int $codeError
     * @return string
     */
    public static function getDescriptionError(int $codeError): string
    {
        return self::descriptionOfErrors()[$codeError];
    }

}