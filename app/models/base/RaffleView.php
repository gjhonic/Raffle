<?php

namespace app\models\base;

use app\models\base\queries\RaffleQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "raffle_view".
 *
 * @property int $id
 * @property int $address_id
 * @property int $raffle_id
 * @property string $created_at
 *
 * @property RaffleStatus $status
 * @property User $user
 * @property RaffleTag[] $raffleTags
 * @property Tag $tags
 */
class RaffleView extends \yii\db\ActiveRecord
{

    public static function tableName(): string
    {
        return '{{%raffle_view}}';
    }

    public function rules(): array
    {
        return [
            [['address_id', 'raffle_id'], 'required'],
            [['address_id', 'raffle_id'], 'integer'],
            [['created_at'], 'safe'],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address_id' => 'id']],
            [['raffle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Raffle::className(), 'targetAttribute' => ['raffle_id' => 'id']],
        ];
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => [],
                ],
            ],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'address_id' => Yii::t('app', 'Address'),
            'raffle_id' => Yii::t('app', 'Raffle'),
            'created_at' => Yii::t('app', 'Created at'),
        ];
    }

    /**
     * Gets query for [[Address]].
     * @return ActiveQuery
     */
    public function getAddress(): ActiveQuery
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }

    /**
     * Gets query for [[Raffle]].
     * @return ActiveQuery
     */
    public function getRaffle(): ActiveQuery
    {
        return $this->hasOne(Raffle::className(), ['id' => 'raffle_id']);
    }
}
