<?php

namespace app\models\db;

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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            ['title', 'string', 'max' => 255],
            ['title', 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'title' => 'Название',
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
     * Gets query for [[RaffleTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRaffleTags()
    {
        return $this->hasMany(RaffleTag::className(), ['tag_id' => 'id']);
    }

    /**
     * Метод находит теги по совпадению с запросом
     * @param $query
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function searchTags($query)
    {
        return self::find()
            ->where(['title' => $query])
            ->all();
    }
}
