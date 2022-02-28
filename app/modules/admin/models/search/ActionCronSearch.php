<?php
/**
 * ActionCronSearch
 * Модель поиска логов крон скриптов
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 */

namespace app\modules\admin\models\search;

use app\modules\admin\models\ActionCron;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ActionCronSearch extends ActionCron
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['controller', 'action'], 'string'],
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
        $query = ActionCron::find();

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
            ]
        );

        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'controller', $this->controller]);
        $query->andFilterWhere(['=', 'action', $this->action]);

        return $dataProvider;
    }
}
