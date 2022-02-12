<?php


namespace app\modules\api\models;


use Yii;

class ErrorApi
{
    const ERROR_EMPTY_CODE_RAFFLE = 1;

    /**
     * Описание ошибок
     * @return array
     */
    public static function descriptionOfErrors(): array
    {
        return [
            self::ERROR_EMPTY_CODE_RAFFLE => Yii::t('app/error', 'Raffle code parameter not specified'),
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