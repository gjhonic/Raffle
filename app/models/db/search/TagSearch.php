<?php
/**
 * TagSearch
 * Модель поиска тегов
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */
namespace app\models\db\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\base\Tag;


class TagSearch extends Tag
{
    public function rules(): array
    {
        return [
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Tag::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->defaultOrder = ['title' => SORT_ASC];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
