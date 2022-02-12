<?php


namespace app\models\system;


class Lang
{
    const LANG_EN = 'en';
    const LANG_RU = 'ru';

    public static function getlanguages(): array
    {
        return [
            self::LANG_EN,
            self::LANG_RU,
        ];
    }
}