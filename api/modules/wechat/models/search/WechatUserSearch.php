<?php

namespace api\modules\wechat\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\wechat\models\WechatUser;

/**
 * WechatUserSearch represents the model behind the search form about `api\modules\wechat\models\WechatUser`.
 */
class WechatUserSearch extends WechatUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'wechat_config_id', 'sex'], 'integer'],
            [['openid', 'nickname', 'province', 'city', 'country', 'headimgurl', 'privilege', 'unionid', 'access_token', 'created_at', 'updated_at', 'subscribed_at'], 'safe'],
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
        $query = WechatUser::find();

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
            'wechat_config_id' => $this->wechat_config_id,
            'sex' => $this->sex,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'subscribed_at' => $this->subscribed_at,
        ]);

        $query->andFilterWhere(['like', 'openid', $this->openid])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'headimgurl', $this->headimgurl])
            ->andFilterWhere(['like', 'privilege', $this->privilege])
            ->andFilterWhere(['like', 'unionid', $this->unionid])
            ->andFilterWhere(['like', 'access_token', $this->access_token]);

        return $dataProvider;
    }
}
