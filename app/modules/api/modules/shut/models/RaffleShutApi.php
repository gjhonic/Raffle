<?php

namespace app\modules\api\modules\shut\models;

use Yii;
use app\modules\api\models\RaffleApi;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "raffle".
 *
 * @property int $id
 * @property string $title
 * @property string|null $short_description
 * @property string|null $description
 * @property string|null $note
 * @property int $user_id
 * @property string|null $video_link
 * @property string|null $image_src
 * @property string|null $date_begin
 * @property string|null $date_end
 * @property int $status_id
 * @property string $code
 * @property string $created_at
 * @property string $updated_at
 *
 * @property RaffleStatus $status
 * @property User $user
 * @property RaffleTag[] $raffleTags
 */
class RaffleShutApi extends RaffleApi
{
    /**
     * Метод возвращает конкурс по коду
     * @param string $code
     * @return array|ActiveRecord|null
     * @throws \yii\db\Exception
     */
    public static function findByCode($code, $field = false){
        return parent::findByCode($code, self::accessFieldRaffle());
    }

    public static function accessFieldRaffle()
    {
        return "raffle.id AS raffle_id,
            raffle.code AS code,
            raffle.title AS title,
            raffle.short_description AS short_description,
            raffle.description AS description,
            raffle.created_at AS created_at,
            raffle.date_begin AS date_begin,
            raffle.date_end AS date_end,
            raffle.note AS note,
            user.id as user_id";
    }
}
