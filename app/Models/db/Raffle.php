<?php

namespace app\models\db;

use Yii;
use yii\behaviors\TimestampBehavior;

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
    //Статусы конкурсов
    const STATUS_APPROVED = "approved";
    const STATUS_APPROVED_ID = 1;

    const STATUS_ON_CHECK = "on check";
    const STATUS_ON_CHECK_ID = 2;

    const STATUS_NOT_APPROVED = "not approved";
    const STATUS_NOT_APPROVED_ID = 3;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'raffle';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'user_id', 'status_id', 'code'], 'required'],
            [['short_description'], 'string', 'max' => 1000],
            [['description'], 'string', 'max' => 5000],
            [['user_id', 'status_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'video_link', 'image_src'], 'string', 'max' => 255],
            [['date_begin', 'date_end'], 'string', 'max' => 20],
            [['code'], 'string', 'max' => 30],
            [['code'], 'unique'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RaffleStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @return string[]
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
     * Метод возвращает пользователя
     * @return User|null
     */
    public function getUser()
    {
        return User::findOne($this->user_id);
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

    /**
     * Метод возвращает все конкурсы пользователя
     * @param $user_id int
     * @param $status_id int|null
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findRaffleByUser($user_id, $status_id=null){
        if($status_id !== null){
            return self::find()
                ->where(['user_id' => $user_id, 'status_id' => $status_id])
                ->orderBy('id DESC')
                ->limit(10)
                ->all();
        }else{
            return self::find()
                ->where(['user_id' => $user_id])
                ->orderBy('id DESC')
                ->limit(10)
                ->all();
        }
    }

    /**
     * Метод возвращает конкурс по коду
     * @param $code
     * @return array|\yii\db\ActiveRecord|null
     */
    public static function findByCode($code){
        return self::find()->where(['code' => $code])->one();
    }

    /**
     * Метод генерирует случайный уникальный код конкурса
     * @return string
     */
    public static function codeGenerate(): string
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $code = substr(str_shuffle($permitted_chars), 0, 25);
        while(self::findByCode($code)){
            $code = substr(str_shuffle($permitted_chars), 0, 25);
        }
        return $code;
    }
}
