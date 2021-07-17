<?php

namespace app\models\db;

use yii\db\ActiveQuery;

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
     * @return string
     */
    public static function tableName(): string
    {
        return 'raffle_status';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 50],
            [['title'], 'unique'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[Raffles]].
     *
     * @return ActiveQuery
     */
    public function getRaffles()
    {
        return $this->hasMany(Raffle::className(), ['status_id' => 'id']);
    }
}
