<?php

namespace app\models\db;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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

    public $tags_string = "";

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
    public function rules(): array
    {
        return [
            [['title', 'user_id', 'status_id', 'code'], 'required'],
            [['short_description'], 'string', 'max' => 1000],
            [['description'], 'string', 'max' => 5000],
            [['description', 'short_description', 'title'], 'trim'],
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

    public function behaviors(): array
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
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
     * @param bool $insert
     * @return bool
     */
    public function afterSave($insert, $changedAttributes)
    {
        if(trim($this->tags_string) != ''){
            $this->clearRaffleTags();
            $this->addTagsFromString();
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return ActiveQuery
     */
    public function getStatus(): ActiveQuery
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
     * @return ActiveQuery
     */
    public function getRaffleTags(): ActiveQuery
    {
        return $this->hasMany(RaffleTag::className(), ['raffle_id' => 'id']);
    }

    public function clearRaffleTags()
    {
        $placeholders = [
            'raffle_id' => $this->id
        ];
        $sql = "DELETE FROM raffle_tag WHERE raffle_id = :raffle_id";
        return Yii::$app->db->createCommand($sql, $placeholders)->queryAll();
    }

    /**
     * Метод прикрепялет теги к конкурсу
     */
    public function addTagsFromString()
    {
        $tags_array = explode(" ", $this->tags_string);
        foreach($tags_array as $tag){
            $tag = trim(substr($tag, 1));
            $tag = mb_strtolower($tag);
            if($tag == ''){
                continue;
            }
            if(($raffle_tag = Tag::find()->where(['title' => $tag])->one()) === null){
                $raffle_tag = new Tag();
                $raffle_tag->title = $tag;
                $raffle_tag->save();
            }
            RaffleTag::add($this->id, $raffle_tag->id);
        }
    }

    /**
     * Метод возвращает список популярных конкурсов
     * @return array|\yii\db\DataReader
     * @throws \yii\db\Exception
     */
    public static function getPopularRaffles()
    {
        $placeholders = [
            'status_id' => self::STATUS_APPROVED_ID
        ];
        $sql = "SELECT raffle.title AS raffle_title,
            raffle.short_description AS raffle_short_description,
            raffle.created_at AS raffle_created_at,
            raffle.code AS raffle_code,
            user.username AS username,
            user.code AS user_code
         FROM raffle
         LEFT JOIN user ON raffle.user_id = user.id
         WHERE raffle.status_id = :status_id
         ORDER BY raffle.id DESC
         LIMIT 30";
        return Yii::$app->db->createCommand($sql, $placeholders)->queryAll();
    }

    /**
     * Метод возвращает конкурсы по тегу
     * @param string $tag
     * @return array|\yii\db\DataReader
     * @throws \yii\db\Exception
     */
    public static function getRafflesByTag($tag)
    {
        $placeholders = [
            'tag' => $tag
        ];
        $sql = "SELECT raffle.title AS raffle_title,
            raffle.short_description AS raffle_short_description,
            raffle.created_at AS raffle_created_at,
            raffle.code AS raffle_code,
            user.username AS username,
            user.code AS user_code
         FROM raffle_tag
         RIGHT JOIN raffle ON raffle_tag.raffle_id = raffle.id
         LEFT JOIN user ON raffle.user_id = user.id
         LEFT JOIN tag ON raffle_tag.tag_id = tag.id
         WHERE tag.title = :tag
         ORDER BY raffle.id DESC
         LIMIT 30";
        return Yii::$app->db->createCommand($sql, $placeholders)->queryAll();
    }

    /**
     * Метод возвращает теги конкурса
     * @param integer $raffle_id
     * @return array|\yii\db\DataReader
     * @throws \yii\db\Exception
     */
    public static function getTags($raffle_id)
    {
        $placeholders = [
            'raffle_id' => $raffle_id
        ];
        $sql = "SELECT tag.title AS tag_title
         FROM raffle_tag
         RIGHT JOIN tag ON raffle_tag.tag_id = tag.id
         WHERE raffle_tag.raffle_id = :raffle_id";
        return Yii::$app->db->createCommand($sql, $placeholders)->queryAll();
    }

    /**
     * Метод возвращает все конкурсы пользователя
     * @param $user_id int
     * @param $status_id int|null
     * @param $limit int
     * @return array|ActiveRecord[]
     */
    public static function findRaffleByUser($user_id, $status_id=null, $limit=10){
        if($status_id !== null){
            return self::find()
                ->where(['user_id' => $user_id, 'status_id' => $status_id])
                ->orderBy('id DESC')
                ->limit($limit)
                ->all();
        }else{
            return self::find()
                ->where(['user_id' => $user_id])
                ->orderBy('id DESC')
                ->limit($limit)
                ->all();
        }
    }

    /**
     * Метод возвращает конкурс по коду
     * @param string $code
     * @return array|ActiveRecord|null
     */
    public static function findByCode($code){
        return self::find()->where(['code' => $code])->one();
    }

    /**
     * Метод возвращает конкурс по коду
     * @param string $code
     * @return array|ActiveRecord|null
     * @throws \yii\db\Exception
     */
    public static function getRaffleByCode($code){
        $placeholders = [
            'raffle_code' => $code
        ];
        $sql = "SELECT raffle.id AS raffle_id,
            raffle.title AS raffle_title,
            raffle.description AS raffle_description,
            raffle.created_at AS raffle_created_at,
            raffle.date_begin AS raffle_date_begin,
            raffle.date_end AS raffle_date_end,
            raffle.status_id AS raffle_status_id,
            raffle.code AS raffle_code,
            user.username AS username,
            user.id AS user_id,
            user.code AS user_code
         FROM raffle
         LEFT JOIN user ON raffle.user_id = user.id
         WHERE raffle.code = :raffle_code";
        return Yii::$app->db->createCommand($sql, $placeholders)->queryOne();
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

    /**
     * Метод находит конкурсы по совпадению с запросом
     * @param $query
     * @return array|ActiveRecord[]
     */
    public static function searchRaffles($query): array
    {
        return self::find()
            ->where(['like', 'title', $query])
            ->orWhere(['like', 'short_description', $query])
            ->orWhere(['like', 'description', $query])
            ->andWhere(['status_id' => Raffle::STATUS_APPROVED_ID])
            ->all();
    }
}
