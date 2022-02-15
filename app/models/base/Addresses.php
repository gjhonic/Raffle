<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "addresses".
 *
 * @property int $id
 * @property string $ip
 * @property string $description
 * @property int $created_at
 *
 */
class Addresses extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%addresses}}';
    }

    public function rules(): array
    {
        return [
            [['ip'], 'required'],
            [['description', 'ip'], 'string'],
            [['created_at'], 'integer'],
            [['ip'], 'unique'],
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
            'ip' => Yii::t('app', 'Ip address'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created at'),
        ];
    }
}
