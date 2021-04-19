<?php
/**
 * UserSearch
 * Модель поиска пользователей
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */
namespace app\models\db\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//Модели БД
use app\models\db\User;


class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'string', 'max' => 255],
            [['name', 'surname'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
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
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->defaultOrder = ['username' => SORT_ASC];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'username', $this->user_username]);
        $query->andFilterWhere(['like', 'name', $this->user_name]);
        $query->andFilterWhere(['like', 'surname', $this->user_surname]);
        $query->andFilterWhere(['like', 'patronymic', $this->user_patronymic]);

        return $dataProvider;
    }
}
