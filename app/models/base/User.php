<?php

namespace app\models\base;

use app\models\behavior\ActiveRecordLogableBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $username
 * @property string $email
 * @property string $email_confirm
 * @property string $password
 * @property int $role_id
 * @property int $status_id
 * @property string $code
 * @property string|null $auth_key
 * @property string|null $access_token
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Post[] $posts
 * @property Raffle[] $raffles
 * @property UserRole $role
 * @property UserStatus $status
 * @property UserOtherInfo[] $userOtherInfos
 */
class User extends \yii\db\ActiveRecord
{
    //Роли пользователей
    const ROLE_ADMIN = "admin";
    const ROLE_ADMIN_ID = 1;

    const ROLE_MODERATOR = "moderator";
    const ROLE_MODERATOR_ID = 2;

    const ROLE_USER = "user";
    const ROLE_USER_ID = 3;

    const ROLE_GUEST = "?";
    const ROLE_AUTHORIZED = "@";

    //Статусы пользователей
    const STATUS_ACTIVE = "active";
    const STATUS_ACTIVE_ID = 1;

    const STATUS_TAG_TO_BAN = "tag to ban";
    const STATUS_TAG_TO_BAN_ID = 2;

    const STATUS_BAN = "ban";
    const STATUS_BAN_ID = 3;

    public static function tableName(): string
    {
        return '{{%user}}';
    }

    public function rules(): array
    {
        return [
            [['name', 'surname', 'username', 'email', 'password', 'role_id', 'status_id', 'code', 'email_confirm'], 'required'],
            [['role_id', 'status_id', 'email_confirm'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'surname', 'email', 'code'], 'string', 'max' => 50],
            [['username', 'password'], 'string', 'max' => 255],
            [['auth_key', 'access_token'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['code'], 'unique'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserRole::className(), 'targetAttribute' => ['role_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            ActiveRecordLogableBehavior::class,
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Name'),
            'surname' => Yii::t('app', 'Surname'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'role_id' => Yii::t('app', 'Role'),
            'status_id' => Yii::t('app', 'Status'),
            'code' => Yii::t('app', 'Code'),
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at')
        ];
    }

    /**
     * Gets query for [[Posts]].
     * @return \yii\db\ActiveQuery
     */
    public function getPosts(): ActiveQuery
    {
        return $this->hasMany(Post::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Raffles]].
     * @return \yii\db\ActiveQuery
     */
    public function getRaffles(): ActiveQuery
    {
        return $this->hasMany(Raffle::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole(): ActiveQuery
    {
        return $this->hasOne(UserRole::class, ['id' => 'role_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStatus(): ActiveQuery
    {
        return $this->hasOne(UserStatus::class, ['id' => 'status_id']);
    }

    /**
     * Метод определяет является пользователь в подписчиках Self User
     * @return bool
     */
    public function mySubsription(): bool
    {
        return Subscriptions::subscriptionCheck($this->id, Yii::$app->user->getId());
    }

    /**
     * Метод определяет является $subscriber_id в подписчиком this user
     * @param int $subscriber_id
     * @return bool
     */
    public function checkSubscription(int $subscriber_id): bool
    {
        return Subscriptions::find()
            ->where(['user_id' => $this->id, 'subscriber_id' => $subscriber_id])
            ->exists();
    }

    /**
     * Gets query for [[UserOtherInfos]].
     * @return \yii\db\ActiveQuery
     */
    public function getUserOtherInfos(): ActiveQuery
    {
        return $this->hasMany(UserOtherInfo::className(), ['user_id' => 'id']);
    }

    /**
     * Метод находит пользователя по коду.
     * @param string $code
     * @return ?User
     */
    public static function findByCode(string $code): ?User
    {
        return self::findOne(['code' => $code]);
    }

    /**
     * Метод находит пользователя по логину.
     * @param string $username
     * @return ?User
     */
    public static function findByUsername(string $username): ?User
    {
        return self::findOne(['username' => $username]);
    }

    /**
     * Метод находит пользователя по почте.
     * @param string $email
     * @return ?User
     */
    public static function findByEmail(string $email): ?User
    {
        return self::findOne(['email' => $email]);
    }

    /**
     * @return mixed
     */
    public static function currentUser()
    {
        return Yii::$app->user->identity;
    }

    /**
     * Метод определяет если аватарка у пользователя
     * @return false
     */
    public function existAva()
    {
        return false;
    }

    /**
     * Метод возвращает приветственное сообщение
     * @return string|null
     */
    public function getHelloMessage()
    {
        return null;
    }

    /**
     * Метод возвращает UserOtherInfo по атрибуту about
     * @return UserOtherInfo|null
     */
    public function getAbout(): ?UserOtherInfo
    {
        return UserOtherInfo::findOne([
            'user_id' => $this->id,
            'atr_id' => UserAttribute::ATTRIBUTE_ABOUT,
        ]);
    }

    /**
     * @return string|null
     */
    public function getAboutInfo(): ?string
    {
        $aboutInfo = $this->getAbout();
        if ($aboutInfo) {
            return $aboutInfo->value;
        } else {
            return null;
        }
    }

    /**
     * @param string $about
     * @return bool
     */
    public function setAbout(string $about): bool
    {
        $userOtherInfo = $this->getAbout();
        if ($userOtherInfo) {
            $userOtherInfo->value = $about;
            return $userOtherInfo->save(false);
        } else {
            $userOtherInfo = new UserOtherInfo();
            $userOtherInfo->user_id = $this->id;
            $userOtherInfo->atr_id = UserAttribute::ATTRIBUTE_ABOUT;
            $userOtherInfo->value = $about;
            return $userOtherInfo->save();
        }
    }

    /**
     * Метод возвращает ссылку на вк
     * @return string|null
     */
    public function getVKLink()
    {
        return null;
    }

    /**
     * Метод возвращает ссылку на facebook
     * @return string|null
     */
    public function getFaceBookLink()
    {
        return null;
    }

    /**
     * Метод возвращает ссылку на instagram
     * @return string|null
     */
    public function getInstagramLink()
    {
        return null;
    }

    /**
     * Метод возвращает ссылку на discord сервер
     * @return string|null
     */
    public function getDiscordLink()
    {
        return null;
    }

    /**
     * Метод возвращает ссылку на YouTube канал
     * @return string|null
     */
    public function getYouTubeLink()
    {
        return null;
    }

    /**
     * Метод находит пользователей по совпадению с запросом
     * @param string $query
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function searchUsers(string $query): array
    {
        return self::find()
            ->andWhere(['=', 'role_id', self::ROLE_USER_ID])
            ->andWhere(['like', 'name', $query])
            ->orWhere(['like', 'surname', $query])
            ->orWhere(['like', 'username', $query])
            ->orderBy('id DESC')
            ->limit(30)
            ->all();
    }
}
