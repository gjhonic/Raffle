<?php

namespace app\modules\api\modules\open\models;

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
 */
class RaffleOpenApi extends Raffle
{
    /**
     * Метод возвращает конкурс по коду
     * @param string $code
     * @return array
     */
    public static function findByCode(string $code): array
    {
        $raffle = parent::findByCode($code);
        $raffleArray = [];
        if ($raffle) {
            $raffleArray = [
                'code' => $raffle->code,
                'title' => $raffle->title,
                'short_description' => $raffle->short_description,
                'description' => $raffle->description,
                'date_begin' => $raffle->date_begin,
                'date_end' => $raffle->date_end,
                'user_code' => $raffle->user->code
            ];
        }
        return $raffleArray;
    }
}
