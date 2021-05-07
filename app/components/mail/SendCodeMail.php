<?php
/**
 * SendCodeMail
 * Компонент для отправки письма с кодом
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */
namespace app\components\mail;

use Yii;

class SendCodeMail {


    /**
     * @param $mail string
     * @param $title string
     * @param $text string
     * @param $code integer
     * @return string
     */
    public static function send($mail, $title, $text, $code){

        $templateParameters = [
            'text' => $text,
            'code' => $code,
        ];
        $result = \Yii::$app->mailer->compose('send_code_mail', $templateParameters)
            ->setFrom([$_ENV['EMAIL_LOGIN'] => 'Raffle'])
            ->setTo($mail)
            ->setSubject($title)
            ->send();

        return $result;
    }
}