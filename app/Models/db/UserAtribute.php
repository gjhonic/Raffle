<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "user_attribute".
 *
 * @property int $id
 * @property string $title
 *
 * @property UserOtherInfo[] $userOtherInfos
 */
class UserAtribute extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_attribute';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 50],
            [['title'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[UserOtherInfos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserOtherInfos()
    {
        return $this->hasMany(UserOtherInfo::className(), ['atr_id' => 'id']);
    }
}
