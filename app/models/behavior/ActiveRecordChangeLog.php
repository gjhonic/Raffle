<?php

namespace app\models\behavior;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "lead".
 *
 * @property int $id
 * @property int $created_at
 *
 */
class ActiveRecordChangeLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%active_record_change_log}}';
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
            [['model_id', 'user_id', 'model'], 'required'],
            [['model_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['old_value', 'new_value'], 'string', 'max' => 255],
            [['model'], 'string', 'max' => 255],
            [['field'], 'string', 'max' => 255],
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

    public static function findByTypeAndId(string $type, int $id): ActiveQuery
    {
        $query = self::find()->where([
            'and',
            ['model' => $type],
            ['model_id' => $id]
        ]);

        return $query;
    }
}
