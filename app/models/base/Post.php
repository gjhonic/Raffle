<?php

namespace app\models\base;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $description
 * @property int $user_id
 *
 * @property User $user
 */
class Post extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'post';
    }

    public function rules(): array
    {
        return [
            [['description', 'user_id'], 'required'],
            [['description'], 'string'],
            [['user_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'description' => Yii::t('app', 'Description'),
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[User]].
     * @return \yii\db\ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
