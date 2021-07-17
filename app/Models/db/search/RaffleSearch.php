<?php
/**
 * RaffleSearch
 * Модель поиска конкурсов
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */
namespace app\models\db\search;

use app\models\db\Raffle;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class RaffleSearch extends Raffle
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title'], 'string', 'max' => 255],
            ['status_id', 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Raffle::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['=', 'status_id', $this->status_id]);

        return $dataProvider;
    }
}
