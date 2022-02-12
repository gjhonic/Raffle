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
 */
class RaffleApi extends Raffle
{
    /**
     * Метод возвращает конкурс по коду
     * @param string $code уникальный код конкурса
     * @param array $fields возвращаемые поля
     * @return array|ActiveRecord|null
     * @throws \yii\db\Exception
     */
    public static function findByCodeApi(string $code, array $fields)
    {
        return parent::find()
            ->select($fields)
            ->joinWith('user')
            ->where(['raffle.code' => $code])
            ->asArray()
            ->one();

        $sql = self::find()
            ->select($fields)
            ->joinWith('user')
            ->where(['raffle.code' => $code]);
            //->asArray()
            //->one();

        return [$sql->createCommand()->getRawSql()];

    }

    /**
     * Метод теги конкурса
     * @param string $code - уникальный код конкурса
     * @return array
     */
    public static function getTagsRaffle(string $code): array
    {
        $raffle = Raffle::findByCode($code);
        $tagsArray = [];
        if ($raffle) {
            $Tags = $raffle->tags;
            $tag_item = [];
            foreach ($Tags as $tag) {
                $tag_item['title'] = $tag->title;
                $tagsArray[] = $tag_item;
            }
        }
        return $tagsArray;
    }
}
