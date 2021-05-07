<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "raffle_status".
 *
 * @property int $id
 * @property string $title
 *
 * @property Raffle[] $raffles
 */
class RaffleStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'raffle_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 50],
            [['title'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[Raffles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRaffles()
    {
        return $this->hasMany(Raffle::className(), ['status_id' => 'id']);
    }
}
