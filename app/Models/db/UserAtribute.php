<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "user_attribute".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $type
 *
 * @property UserOtherInfo[] $userOtherInfos
 */
class UserAtribute extends \yii\db\ActiveRecord
{
    const TYPE_COMMON = 'common';
    const TYPE_SOCIAL_LINK = 'social link';

    /**
     * @return string
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
            [['title', 'type'], 'required'],
            ['title', 'string', 'max' => 20],
            ['title', 'unique'],
            ['description', 'string', 'max' => 255],
            ['type', 'string', 'max' => 20],
            ['type', 'default', 'value' => 'common'],
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
}
