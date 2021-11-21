<?php

namespace app\models\behavior;

use Yii;
use yii\behaviors\TimestampBehavior;

class ActiveRecordCreateLog extends \yii\db\ActiveRecord
{
    const ACTION_CREATE = 0;
    const ACTION_DELETE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%active_record_create_log}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model_id', 'user_id', 'action', 'model'], 'required'],
            [['model_id', 'user_id', 'created_at', 'action', 'updated_at'], 'integer'],
            [['model'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
