<?php

namespace app\models\base;

use app\models\behavior\ActiveRecordLogableBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "subscription".
 *
 * @property int $id
 * @property int $subscription
 * @property int $user_id
 *
 * @property User $user
 * @property User $subscriber
 */
class Subscriptions extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%subscription}}';
    }

    public function behaviors(): array
    {
        return [
            ActiveRecordLogableBehavior::class,
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => [],
                ],
            ],
        ];
    }

    public function rules(): array
    {
        return [
            [['subscriber_id', 'user_id'], 'required'],
            [['subscriber_id', 'user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['subscriber_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['subscriber_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'Id',
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * Gets query for [[User]].
     * @return \yii\db\ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[User]].
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriber(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'subscriber_id']);
    }

    /**
     * @param int $user_id
     * @param int $subscriber_id
     * @return bool
     */
    public static function subscriptionCheck(int $user_id, int $subscriber_id): bool
    {
        return self::find()
            ->where([
                'user_id' => $user_id,
                'subscriber_id' => $subscriber_id,
            ])
            ->exists();
    }
}
