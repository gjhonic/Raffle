<?php


namespace app\modules\api\models;

use Yii;

class MethodsApi
{
    //Версии апи
    const API_VERSION_OPEN = 'open';
    const API_VERSION_SHUT = 'shut';

    //Методы апи
    const METHOD_OPEN_RAFFLE_GET = 'raffle/get';
    const METHOD_OPEN_RAFFLE_TAGS = 'raffle/tags';
    const METHOD_OPEN_USER_GET = 'user/get';
    const METHOD_OPEN_USER_RAFFLES = 'user/raffles';

    /**
     * Массив версий апи
     * @return array
     */
    public static function getVersion(): array
    {
        return [
            self::API_VERSION_OPEN,
            self::API_VERSION_SHUT
        ];
    }

    /**
     * Массив версий апи мап версия
     * @return array
     */
    public static function getVersionMap(): array
    {
        $versions = self::getVersion();
        return array_combine($versions, $versions);
    }

    /**
     * Массив методов апи
     * @return array
     */
    public static function getMethods(): array
    {
        return [
            self::METHOD_OPEN_RAFFLE_GET,
            self::METHOD_OPEN_RAFFLE_TAGS,
            self::METHOD_OPEN_USER_GET,
            self::METHOD_OPEN_USER_RAFFLES,
        ];
    }

    /**
     * Массив методов апи мап версия
     * @return array
     */
    public static function getMethodsMap(): array
    {
        $methods = self::getMethods();
        return array_combine($methods, $methods);
    }
}