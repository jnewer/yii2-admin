<?php

namespace common\modules\region\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\region\models\Street;

/**
 * StreetSearch represents the model behind the search form about `common\modules\region\models\Street`.
 */
class StreetSearch extends Street
{
    public $area_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pid'], 'integer'],
            [['name', 'area_name'], 'safe'],
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
        $query = Street::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>['defaultOrder'=>['id'=> SORT_DESC]],
            'pagination'=>['validatePage'=>false],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'pid' => $this->pid,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        if ($this->area_name) {
            $query->joinWith(['area']);
            $query->andFilterWhere(['like', 'area.name', $this->area_name]);
        }

        return $dataProvider;
    }
}
