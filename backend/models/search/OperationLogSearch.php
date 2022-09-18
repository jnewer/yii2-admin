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

    public $date_from, $date_to;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'time', 'operator_id', 'is_delete'], 'integer'],
            [['date', 'ip', 'operator_name', 'type', 'category', 'description', 'model', 'model_pk', 'model_attributes_old', 'model_attributes_new', 'date_from', 'date_to'], 'safe'],
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
            'date' => $this->date,
            'time' => $this->time,
            'operator_id' => $this->operator_id,
            'is_delete' => $this->is_delete,
        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'operator_name', $this->operator_name])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'model_pk', $this->model_pk]);

        if ($this->date_from) {
            $query->andFilterWhere(['>=', 'date', $this->date_from . ' 00:00:00']);
        }
        if ($this->date_to) {
            $query->andFilterWhere(['<=', 'date', $this->date_to . ' 23:59:59']);
        }

        return $dataProvider;
    }
}
