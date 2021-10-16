<?php

namespace app\models\db;

use Yii;

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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_other_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'atr_id'], 'required'],
            [['user_id', 'atr_id'], 'integer'],
            [['value'], 'string'],
            [['atr_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserAttribute::className(), 'targetAttribute' => ['atr_id' => 'id']],
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
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAtr()
    {
        return $this->hasOne(UserAttribute::className(), ['id' => 'atr_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
