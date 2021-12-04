<?php
/**
 * UserSearch
 * Модель поиска пользователей
 * @copyright Copyright (c) 2021 Eugene Andreev
 * @author Eugene Andreev <gjhonic@gmail.com>
 *
 */
namespace app\models\base\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\base\User;


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
            [['role_id', 'status_id'], 'integer'],
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
    public function search($params, $mod='default')
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if($mod == 'moder'){
            $query->andFilterWhere(['>', 'role_id', 2]);
        }elseif($mod == 'admin'){
            $query->andFilterWhere(['>', 'role_id', 1]);
        }

        $dataProvider->sort->defaultOrder = ['username' => SORT_ASC];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'username', $this->username]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'surname', $this->surname]);

        if($mod == 'default'){
            $query->andFilterWhere(['=', 'role_id', $this->role_id]);
        }else{
            $query->andFilterWhere(['=', 'status_id', $this->status_id]);
        }

        return $dataProvider;
    }
}
