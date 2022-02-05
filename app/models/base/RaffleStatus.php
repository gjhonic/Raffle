<?php

namespace app\models\base;

use Yii;
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
    public static function tableName(): string
    {
        return '{{%raffle_status}}';
    }

    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 50],
            [['title'], 'unique'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * Gets query for [[Raffles]].
     * @return ActiveQuery
     */
    public function getRaffles(): ActiveQuery
    {
        return $this->hasMany(Raffle::className(), ['status_id' => 'id']);
    }
}
