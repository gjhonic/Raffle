<?php

namespace app\models\base;

use Yii;
use yii\db\ActiveQuery;
use Yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "support".
 *
 * @property int $id
 * @property string $description
 * @property int $user_id
 * @property int $status
 * @property int|null $created_at
 *
 * @property User $user
 */
class Support extends \yii\db\ActiveRecord
{
    //Статусы обращений
    const STATUS_NOT_VIEWED = 0;
    const STATUS_VIEWED = 1;
    const STATUS_IMPORTANT = 2;

    public static function tableName(): string
    {
        return 'support';
    }

    public function rules(): array
    {
        return [
            [['title', 'description', 'user_id', 'status'], 'required'],
            [['description', 'title'], 'string'],
            [['user_id', 'status', 'created_at'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['title'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 5000],
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
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'user_id' => 'Пользователь',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
        ];
    }

    /**
     * Метод возвращает пользователя обращения
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Метод установливает статус просмотрено на обращении
     * @return bool
     */
    public function setViewed(): bool
    {
        $this->status = self::STATUS_VIEWED;
        return $this->update();
    }

    /**
     * Метод установливает статус важно на обращении
     * @return bool
     */
    public function setTag(): bool
    {
        $this->status = self::STATUS_IMPORTANT;
        return $this->update();
    }
}