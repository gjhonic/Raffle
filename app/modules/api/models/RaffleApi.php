<?php

namespace app\modules\api\models;

use Yii;
use app\models\base\Raffle;
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
class RaffleApi extends \yii\db\ActiveRecord
{
    /**
     * Метод возвращает конкурс по коду
     * @param string $code - уникальный код конкурса
     * @param string $field - возвращаемые поля
     * @return array|ActiveRecord|null
     * @throws \yii\db\Exception
     */
    public static function findByCode($code, $field){
        $placeholders = [
            'raffle_code' => $code,
            'raffle_status_approved' => Raffle::STATUS_APPROVED_ID
        ];
        $sql = "SELECT ".$field."
         FROM raffle
         LEFT JOIN user ON user.id = raffle.user_id
         WHERE raffle.code = :raffle_code
         AND raffle.status_id = :raffle_status_approved";
        return Yii::$app->db->createCommand($sql, $placeholders)->queryOne();
    }

    /**
     * Метод теги конкурса
     * @param string $code - уникальный код конкурса
     * @param string $field - возвращаемые поля
     * @return array|ActiveRecord|null
     * @throws \yii\db\Exception
     */
    public static function getTagsRaffle($code){
        $placeholders = [
            'raffle_code' => $code,
            'raffle_status_approved' => Raffle::STATUS_APPROVED_ID
        ];
        $sql = "SELECT tag.title
         FROM raffle
         LEFT JOIN raffle_tag ON raffle_tag.raffle_id = raffle.id
         LEFT JOIN tag ON tag.id = raffle_tag.tag_id
         WHERE raffle.code = :raffle_code
         AND raffle.status_id = :raffle_status_approved";
        return Yii::$app->db->createCommand($sql, $placeholders)->queryAll();
    }
}
