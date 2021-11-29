<?php

namespace app\models\base;

use app\models\db\RaffleStatus;
use app\models\db\RaffleTag;
use app\models\db\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "raffle".
 *
 * @property int $id
 * @property string $title
 * @property string|null $short_description
 * @property string|null $description
 * @property string|null $note
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
 * @property Tag $tags
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

    public static function tableName(): string
    {
        return '{{%raffle}}';
    }

    public function rules(): array
    {
        return [
            [['title', 'user_id', 'status_id', 'code'], 'required'],
            [['short_description', 'note'], 'string', 'max' => 1000],
            [['description'], 'string', 'max' => 5000],
            [['description', 'short_description', 'title', 'note'], 'trim'],
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

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('app', 'Title'),
            'short_description' => 'Короткое описание',
            'description' => Yii::t('app', 'Description'),
            'user_id' => Yii::t('app', 'User'),
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

    public function afterSave($insert, $changedAttributes)
    {
        if (trim($this->tags_string) != '') {
            $this->clearRaffleTags();
            $this->addTagsFromString();
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Gets query for [[Status]].
     * @return ActiveQuery
     */
    public function getStatus(): ActiveQuery
    {
        return $this->hasOne(RaffleStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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

    public function clearRaffleTags(): bool
    {
        return (bool)(new Query)
            ->createCommand()
            ->delete('raffle_tag', ['raffle_id' => $this->id])
            ->execute();
    }

    /**
     * Метод прикрепялет теги к конкурсу
     */
    public function addTagsFromString()
    {
        $tags_array = explode(" ", $this->tags_string);
        foreach ($tags_array as $tag) {
            $tag = trim(substr($tag, 1));
            $tag = mb_strtolower($tag);
            if ($tag == '') {
                continue;
            }
            if (($raffle_tag = Tag::find()->where(['title' => $tag])->one()) === null) {
                $raffle_tag = new Tag();
                $raffle_tag->title = $tag;
                $raffle_tag->save();
            }
            RaffleTag::add($this->id, $raffle_tag->id);
        }
    }

    /**
     * Метод проверяет является ли пользователь автором конкурса
     * @return bool
     */
    public function isAuthor(): bool
    {
        return (Yii::$app->user->identity->getId() === $this->user_id);
    }

    /**
     * Метод возвращает список популярных конкурсов
     * @param array $filter
     * @param integer $page
     * @return array|\yii\db\DataReader
     * @throws \yii\db\Exception
     */
    public static function getPopularRaffles($filter = [], $page = 0)
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
             WHERE raffle.status_id = :status_id";

        $was_order = 0;

        if ($filter == []) {
            $sql .= " ORDER BY raffle.id DESC";
        }

        if (isset($filter['filter-group'])) {
            if ($filter['filter-group'] == 'user') {
                $sql .= " ORDER BY user.id";
                $was_order = 1;
            }
        }

        if (isset($filter['filter-date'])) {
            if ($filter['filter-date'] == 'old') {
                if ($was_order) {
                    $sql .= ',';
                } else {
                    $sql .= ' ORDER BY';
                }
                $sql .= " raffle.id ASC";
                $was_order = 1;
            } elseif ($filter['filter-date'] == 'new') {
                if ($was_order) {
                    $sql .= ',';
                } else {
                    $sql .= ' ORDER BY';
                }
                $sql .= " raffle.id DESC";
                $was_order = 1;
            }
        }

        if (isset($filter['filter-abc'])) {
            if ($filter['filter-abc'] == 'abc') {
                if ($was_order) {
                    $sql .= ',';
                } else {
                    $sql .= ' ORDER BY';
                }
                $sql .= " raffle.title ASC";
            } elseif ($filter['filter-abc'] == 'zyx') {
                if ($was_order) {
                    $sql .= ',';
                } else {
                    $sql .= ' ORDER BY';
                }
                $sql .= " raffle.title DESC";
            }
        }

        if ($page > 0) {
            $count = 5;
            $offset = 20 + ($page - 1) * $count;
            $placeholders['offset'] = $offset;
            $placeholders['count'] = $count;
            $sql .= " LIMIT :offset, :count";
        } else {
            $sql .= " LIMIT 20";
        }

        return Yii::$app->db->createCommand($sql)->bindValues($placeholders)->queryAll();
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
     * @return ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable('raffle_tag', ['raffle_id' => 'id']);
    }

    /**
     * Метод возвращает все конкурсы пользователя
     * @param int $user_id
     * @param int|null $status_id
     * @param int $limit
     * @return array|ActiveRecord[]
     */
    public static function findRafflesByUser($user_id, $status_id = null, $limit = 10)
    {
        $raffles = self::find()
            ->where(['user_id' => $user_id])
            ->orderBy('id DESC')
            ->limit($limit);
        if ($status_id !== null) {
            $raffles->andWhere(['status_id' => $status_id]);
        }
        return $raffles->all();
    }

    /**
     * Метод возвращает конкурс по коду
     * @param string $code
     * @return array|Raffle|null
     */
    public static function findByCode(string $code)
    {
        return self::find()
            ->where(['code' => $code])
            ->one();
    }

    /**
     * Метод возвращает конкурс по коду
     * @param string $code
     * @return array|ActiveRecord|null
     * @throws \yii\db\Exception
     */
    public static function getRaffleByCode($code)
    {
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
            raffle.note AS raffle_note,
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
        //TODO обрати внимание
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $code = substr(str_shuffle($permitted_chars), 0, 25);
        while (self::findByCode($code)) {
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
        $placeholders = [
            'query' => '%' . $query . '%',
            'status_id' => Raffle::STATUS_APPROVED_ID,
        ];
        $sql = "SELECT raffle.title AS raffle_title,
            raffle.short_description AS raffle_short_description,
            raffle.created_at AS raffle_created_at,
            raffle.code AS raffle_code,
            user.username AS username,
            user.code AS user_code
         FROM raffle
         LEFT JOIN user ON raffle.user_id = user.id
         WHERE (raffle.title LIKE :query)
         OR (raffle.short_description LIKE :query)
         OR (raffle.description LIKE :query)
         AND (raffle.status_id = :status_id)
         ORDER BY raffle.id DESC
         LIMIT 30";
        return Yii::$app->db->createCommand($sql, $placeholders)->queryAll();
    }
}
