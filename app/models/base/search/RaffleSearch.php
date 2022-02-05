<?php
/**
 * RaffleSearch
 * Модель поиска конкурсов
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */
namespace app\models\base\search;

use app\models\base\Raffle;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * @property int $tag_id
 */
class RaffleSearch extends Raffle
{

    public $tag_id;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title'], 'string', 'max' => 255],
            ['status_id', 'integer'],
            [['tag_id'], 'safe'],
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

        if (!($this->load($params) && $this->validate()) && empty($this->tag_id)) {
            return $dataProvider;
        }

        $query->joinWith('raffleTags');

        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['=', 'status_id', $this->status_id]);

        if(!empty($this->tag_id)){
            $query->andFilterWhere(['=', 'raffle_tag.tag_id', $this->tag_id]);
        }

        return $dataProvider;
    }
}
