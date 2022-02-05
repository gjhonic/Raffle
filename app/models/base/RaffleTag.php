<?php

namespace app\models\base;

use yii\db\ActiveQuery;

/**
 * This is the model class for table "raffle_tag".
 *
 * @property int|null $raffle_id
 * @property int|null $tag_id
 *
 * @property Raffle $raffle
 * @property Tag $tag
 */
class RaffleTag extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%raffle_tag}}';
    }

    public function rules(): array
    {
        return [
            [['raffle_id', 'tag_id'], 'integer'],
            [['raffle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Raffle::className(), 'targetAttribute' => ['raffle_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'raffle_id' => 'Raffle ID',
            'tag_id' => 'Tag ID',
        ];
    }

    /**
     * Gets query for [[Raffle]].
     * @return ActiveQuery
     */
    public function getRaffle(): ActiveQuery
    {
        return $this->hasOne(Raffle::className(), ['id' => 'raffle_id']);
    }

    /**
     * Gets query for [[Tag]].
     * @return ActiveQuery
     */
    public function getTag(): ActiveQuery
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }

    /**
     * Метод связывает конкурс и тег
     * @param int $raffle_id
     * @param int $tag_id
     * @return bool
     */
    public static function add(int $raffle_id, int $tag_id): bool
    {
        $raffle_tag = new self();
        $raffle_tag->raffle_id = $raffle_id;
        $raffle_tag->tag_id = $tag_id;
        return $raffle_tag->save();
    }
}
