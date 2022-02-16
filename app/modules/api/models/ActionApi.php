<?php

namespace app\modules\api\models;

use app\models\base\Address;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "addresses".
 *
 * @property int $id
 * @property int $address_id
 * @property string $method
 * @property string $version
 * @property int $created_at
 *
 */
class ActionApi extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%action_api}}';
    }

    public function rules(): array
    {
        return [
            [['address_id', 'method'], 'required'],
            [['method', 'version'], 'string'],
            [['created_at', 'address_id'], 'integer'],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address_id' => 'id']],
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
            'address_id' => Yii::t('app', 'Ip address'),
            'method' => Yii::t('app', 'Method'),
            'version' => Yii::t('app', 'Version'),
            'created_at' => Yii::t('app', 'Created at'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }
}
