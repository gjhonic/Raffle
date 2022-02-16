<?php
/**
 * ActionApiSearch
 * Модель поиска ActionApi
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */
namespace app\modules\api\models\search;

use app\modules\api\models\ActionApi;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 */
class ActionApiSearch extends ActionApi
{

    public $address;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['method', 'version', 'address'], 'safe'],
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
        $query = ActionApi::find()
            ->joinWith('address');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        if (!($this->load($params) && $this->validate()) && empty($this->tag_id)) {
            return $dataProvider;
        }

        if(!empty($this->version)){
            $query->andWhere(['version' => $this->version]);
        }

        if(!empty($this->method)){
            $query->andWhere(['method' => $this->method]);
        }

        if(!empty($this->address)){
            $query->andWhere(['LIKE', 'addresses.ip', $this->address]);
        }

        return $dataProvider;
    }
}
