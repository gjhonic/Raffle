<?php

namespace app\models\db;

use Yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\models\db\User;

/**
 * This is the model class for table "support".
 *
 * @property int $id
 * @property string $description
 * @property int $user_id
 * @property int $status
 * @property int|null $created_at
 */
class Support extends \yii\db\ActiveRecord
{
    //Статусы обращений
    const STATUS_NOT_VIEWED = 0;
    const STATUS_VIEWED = 1;
    const STATUS_IMPORTANT = 2;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'support';
    }

    /**
     * @return array
     */
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

    public function behaviors()
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

    /**
     * @return string[]
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Тема',
            'description' => 'Описание',
            'user_id' => 'Пользователь',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
        ];
    }

    /**
     * Метод возвращает пользователя обращения
     * @return \app\models\db\User
     */
    public function getUser()
    {
        return User::findOne($this->user_id);
    }

    /**
     * Метод установливает статус просмотрено на обращении
     */
    public function setViewed(): void
    {
        $this->status = self::STATUS_VIEWED;
        $this->update();
    }

    /**
     * Метод установливает статус важно на обращении
     */
    public function setTag(): void
    {
        $this->status = self::STATUS_IMPORTANT;
        $this->update();
    }
}