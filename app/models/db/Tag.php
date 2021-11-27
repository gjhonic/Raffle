<?php

namespace app\models\db;

use app\models\behavior\ActiveRecordLogableBehavior;
use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string $title
 *
 * @property RaffleTag[] $raffleTags
 */
class Tag extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%tag}}';
    }

    public function behaviors(): array
    {
        return [
            ActiveRecordLogableBehavior::class,
        ];
    }

    public function rules(): array
    {
        return [
            ['title', 'required'],
            ['title', 'string', 'max' => 255],
            ['title', 'unique'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'Id',
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->title = mb_strtolower($this->title);
        return parent::beforeSave($insert);
    }

    /**
     * Метод находит теги по совпадению с запросом.
     * @param string $query
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function searchTags(string $query): array
    {
        return self::find()
            ->where(['LIKE', 'title', $query])
            ->orderBy('id')
            ->limit(30)
            ->all();
    }
}
