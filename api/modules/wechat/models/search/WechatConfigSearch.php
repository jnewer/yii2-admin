<?php

namespace api\modules\wechat\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\wechat\models\WechatConfig;

/**
 * WechatConfigSearch represents the model behind the search form about `api\modules\wechat\models\WechatConfig`.
 */
class WechatConfigSearch extends WechatConfig
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'kind', 'auth_type', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'app_id', 'app_secret', 'server_url', 'token', 'encoding_aes_key', 'login_email', 'login_password', 'original_id', 'qrcode_url', 'welcome_msg'], 'safe'],
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
        $query = WechatConfig::find();

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
            'kind' => $this->kind,
            'auth_type' => $this->auth_type,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'app_id', $this->app_id])
            ->andFilterWhere(['like', 'app_secret', $this->app_secret])
            ->andFilterWhere(['like', 'server_url', $this->server_url])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'encoding_aes_key', $this->encoding_aes_key])
            ->andFilterWhere(['like', 'login_email', $this->login_email])
            ->andFilterWhere(['like', 'login_password', $this->login_password])
            ->andFilterWhere(['like', 'original_id', $this->original_id])
            ->andFilterWhere(['like', 'qrcode_url', $this->qrcode_url])
            ->andFilterWhere(['like', 'welcome_msg', $this->welcome_msg]);

        return $dataProvider;
    }
}
