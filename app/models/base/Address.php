<?php

namespace app\models\base;

use app\models\behavior\ActiveRecordLogableBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "addresses".
 *
 * @property int $id
 * @property string $ip
 * @property int $status_id
 * @property string $note
 * @property string $description
 * @property int $created_at
 * @property int $updated_at
 *
 */
class Address extends ActiveRecord
{
    const STATUS_OK = 1;
    const STATUS_NEWEST = 2;
    const STATUS_NEW = 3;
    const STATUS_OLD = 4;

    const STATUS_WARNING = 5;
    const STATUS_BAN = 6;


    public static function tableName(): string
    {
        return '{{%addresses}}';
    }

    public function rules(): array
    {
        return [
            [['ip'], 'required'],
            [['description', 'ip', 'note'], 'string'],
            [['status_id'], 'integer'],
            [['ip'], 'unique'],
        ];
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            ActiveRecordLogableBehavior::class,
        ];
    }


    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'ip' => Yii::t('app', 'IP address'),
            'status_id' => Yii::t('app', 'Status'),
            'note' => Yii::t('app', 'Note'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at')
        ];
    }

    /**
     * @param string $ipAddress
     * @return Address
     */
    public static function getAddress(string $ipAddress): Address
    {
        $address = self::findOne(['ip' => $ipAddress]);
        if (!$address) {
            $address = new Address();
            $address->ip = $ipAddress;
            $address->status_id = self::STATUS_NEWEST;
            $address->save();
        }
        return $address;
    }

    /**
     * Возвращает массив статусов
     * @return array
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_OK => 'ok',
            self::STATUS_NEWEST => 'newest',
            self::STATUS_NEW => 'new',
            self::STATUS_OLD => 'old',
            self::STATUS_WARNING => 'warning',
            self::STATUS_BAN => 'ban',
        ];
    }

    /**
     * Возвращает текст статуса
     * @param int $status_id
     * @return string
     */
    public static function getStatus(int $status_id): string
    {
        return self::getStatuses()[$status_id];
    }
}
