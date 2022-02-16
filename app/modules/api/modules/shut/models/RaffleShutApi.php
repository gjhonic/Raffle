<?php

namespace app\modules\api\modules\shut\models;

use app\models\base\Raffle;
use Yii;
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
class RaffleShutApi extends Raffle
{
    /**
     * Метод возвращает конкурс по коду
     * @param string $code
     * @return array|ActiveRecord|null
     * @throws \yii\db\Exception
     */
    public static function findByCode($code, $field = false){
        $raffle = parent::findByCode($code);
        $raffleArray = [];
        if ($raffle) {
            $raffleArray = [
                'id' => $raffle->id,
                'code' => $raffle->code,
                'title' => $raffle->title,
                'short_description' => $raffle->short_description,
                'description' => $raffle->description,
                'created_at' => date('Y-m-d', $raffle->created_at),
                'date_begin' => $raffle->date_begin,
                'date_end' => $raffle->date_end,
                'user_code' => $raffle->user->code
            ];
        }
        return $raffleArray;
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
