<?php

namespace app\models\base;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "user_other_info".
 *
 * @property int $user_id
 * @property int $atr_id
 * @property string|null $value
 *
 * @property UserAttribute $atr
 * @property User $user
 */
class UserOtherInfo extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%user_other_info}}';
    }

    public function rules(): array
    {
        return [
            [['user_id', 'atr_id'], 'required'],
            [['user_id', 'atr_id'], 'integer'],
            [['value'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'atr_id' => 'Atr ID',
            'value' => 'Value',
        ];
    }

    /**
     * Gets query for [[Atr]].
     * @return ActiveQuery
     */
    public function getAtr(): ActiveQuery
    {
        return $this->hasOne(UserAttribute::className(), ['id' => 'atr_id']);
    }

    /**
     * Gets query for [[User]].
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
