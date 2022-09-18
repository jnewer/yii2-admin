<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\LoginLog;

/**
 * LoginLogSearch represents the model behind the search form of `\backend\models\LoginLog`.
 */
class LoginLogSearch extends LoginLog
{
    public $created_at_from, $created_at_to;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['username', 'login_ip', 'created_at', 'created_at_from', 'created_at_to'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = LoginLog::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>['defaultOrder'=>['id'=> SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'login_ip', $this->login_ip]);

        if ($this->created_at_from) {
            $query->andFilterWhere(['>=', 'created_at', $this->created_at_from . ' 00:00:00']);
        }
        if ($this->created_at_to) {
            $query->andFilterWhere(['<=', 'created_at', $this->created_at_to . ' 23:59:59']);
        }

        return $dataProvider;
    }
}
