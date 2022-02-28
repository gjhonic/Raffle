<?php

namespace app\modules\admin\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "action_cron".
 *
 * @property int $id
 * @property string $controller
 * @property string $action
 * @property int $result
 * @property int $created_at
 *
 */
class ActionCron extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%action_cron}}';
    }

    public function rules(): array
    {
        return [
            [['controller', 'action', 'result'], 'required'],
            [['controller', 'action'], 'string'],
            [['result'], 'integer'],
            [['created_at'], 'safe'],
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
            'controller' => Yii::t('app', 'Controller'),
            'action' => Yii::t('app', 'Action'),
            'result' => Yii::t('app', 'Result'),
            'created_at' => Yii::t('app', 'Created at'),
        ];
    }

}
