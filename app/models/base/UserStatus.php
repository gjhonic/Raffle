<?php

namespace app\models\base;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "user_status".
 *
 * @property int $id
 * @property string $title
 *
 * @property User[] $users
 */
class UserStatus extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'user_status';
    }

    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 50],
            [['title'], 'unique'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[Users]].
     * @return ActiveQuery
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(User::className(), ['status_id' => 'id']);
    }
}
