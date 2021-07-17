<?php

namespace app\models\db;

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
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'raffle_tag';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['raffle_id', 'tag_id'], 'integer'],
            [['raffle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Raffle::className(), 'targetAttribute' => ['raffle_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'raffle_id' => 'Raffle ID',
            'tag_id' => 'Tag ID',
        ];
    }

    /**
     * Gets query for [[Raffle]].
     *
     * @return ActiveQuery
     */
    public function getRaffle()
    {
        return $this->hasOne(Raffle::className(), ['id' => 'raffle_id']);
    }

    /**
     * Gets query for [[Tag]].
     *
     * @return ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }
}
