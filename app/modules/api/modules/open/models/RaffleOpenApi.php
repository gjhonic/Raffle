<?php

namespace app\modules\api\modules\open\models;

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
class RaffleOpenApi extends RaffleApi
{
    /**
     * Метод возвращает конкурс по коду
     * @param string $code
     * @return array|ActiveRecord|null
     * @throws \yii\db\Exception
     */
    public static function findByCodeApi(string $code, array $field = []){
        return parent::findByCodeApi($code, self::accessFieldRaffle());
    }

    /**
     * @return string[]
     */
    public static function accessFieldRaffle(): array
    {
        return [
            'raffle.code AS code',
            'raffle.title',
            'raffle.short_description',
            'raffle.description',
            'raffle.created_at',
            'raffle.date_begin',
            'raffle.date_end',
            'user.username',
        ];
    }
}
