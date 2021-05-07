<?php

namespace app\models\db;

use Yii;

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
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'raffle_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['raffle_id', 'tag_id'], 'integer'],
            [['raffle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Raffle::className(), 'targetAttribute' => ['raffle_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'raffle_id' => 'Raffle ID',
            'tag_id' => 'Tag ID',
        ];
    }

    /**
     * Gets query for [[Raffle]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRaffle()
    {
        return $this->hasOne(Raffle::className(), ['id' => 'raffle_id']);
    }

    /**
     * Gets query for [[Tag]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }
}
