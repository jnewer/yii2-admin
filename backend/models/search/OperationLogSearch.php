<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OperationLog;

/**
 * OperationLogSearch represents the model behind the search form of `\backend\models\OperationLog`.
 */
class OperationLogSearch extends OperationLog
{

    public $created_at_from;
    public $created_at_to;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','operator_id'], 'integer'],
            [['date', 'ip', 'operator_name', 'type', 'category', 'description', 'model', 'model_pk', 'model_attributes_old', 'model_attributes_new', 'created_at_from', 'created_at_to'], 'safe'],
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
        $query = OperationLog::find();

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
            'created_at' => $this->created_at,
            'operator_id' => $this->operator_id,
        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'operator_name', $this->operator_name])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'model_pk', $this->model_pk]);

        if ($this->created_at_from) {
            $query->andFilterWhere(['>=', 'created_at', $this->created_at_from . ' 00:00:00']);
        }
        if ($this->created_at_to) {
            $query->andFilterWhere(['<=', 'created_at', $this->created_at_to . ' 23:59:59']);
        }

        return $dataProvider;
    }
}
