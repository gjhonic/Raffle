<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "raffle".
 *
 * @property int $id
 * @property string $title
 * @property string|null $short_description
 * @property string|null $description
 * @property int $user_id
 * @property string|null $video_link
 * @property string|null $image_src
 * @property string|null $date_begin
 * @property string|null $date_end
 * @property int $status_id
 * @property string $code
 * @property string $created_at
 * @property string $updated_at
 *
 * @property RaffleStatus $status
 * @property User $user
 * @property RaffleTag[] $raffleTags
 */
class Raffle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'raffle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'user_id', 'status_id', 'code', 'created_at', 'updated_at'], 'required'],
            [['short_description', 'description'], 'string'],
            [['user_id', 'status_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'video_link', 'image_src'], 'string', 'max' => 255],
            [['date_begin', 'date_end'], 'string', 'max' => 20],
            [['code'], 'string', 'max' => 100],
            [['code'], 'unique'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RaffleStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'short_description' => 'Короткое описание',
            'description' => 'Описание',
            'user_id' => 'Пользователь',
            'video_link' => 'Видео ресурс',
            'image_src' => 'Изображение',
            'date_begin' => 'Старт конкурса',
            'date_end' => 'Конец конкурса',
            'status_id' => 'Статус',
            'code' => 'Код',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
        ];
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(RaffleStatus::className(), ['id' => 'status_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[RaffleTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRaffleTags()
    {
        return $this->hasMany(RaffleTag::className(), ['raffle_id' => 'id']);
    }
}
