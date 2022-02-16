<?php
/**
 * AddressSearch
 * Модель поиска ip sадресов
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */

namespace app\modules\admin\models\search;

use app\models\base\Address;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class AddressSearch extends Address
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['status_id'], 'integer'],
            [['ip', 'note'], 'safe'],
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
        $query = Address::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if (!empty($this->ip)) {
            $query->andWhere(['LIKE', 'ip', $this->ip]);
        }

        if (!empty($this->status_id)) {
            $query->andWhere(['=', 'status_id', $this->status_id]);
        }

        if (!empty($this->note)) {
            $query->andWhere(['LIKE', 'note', $this->note]);
        }

        return $dataProvider;
    }
}
