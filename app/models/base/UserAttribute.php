<?php

namespace app\models\base;

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
class UserAttribute extends \yii\db\ActiveRecord
{
    const TYPE_COMMON = 'common';
    const TYPE_SOCIAL_LINK = 'social link';

    public static function tableName(): string
    {
        return 'user_attribute';
    }

    public function rules(): array
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

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('app', 'Title'),
        ];
    }
}
