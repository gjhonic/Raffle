<?php

namespace app\models\base;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "user_role".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 *
 * @property User[] $users
 */
class UserRole extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'user_role';
    }

    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 50],
            [['title'], 'unique'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Users]].
     * @return ActiveQuery
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(User::className(), ['role_id' => 'id']);
    }
}
