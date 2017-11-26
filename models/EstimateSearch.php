<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Estimate;

/**
 * EstimateSearch represents the model behind the search form about `app\models\Estimate`.
 */
class EstimateSearch extends Estimate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['code', 'seller_name', 'client_name', 'ruc'], 'safe'],
            [['total', 'tax'], 'number'],
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
        $query = Estimate::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'total' => $this->total,
            'tax' => $this->tax,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'seller_name', $this->seller_name])
            ->andFilterWhere(['like', 'client_name', $this->client_name])
            ->andFilterWhere(['like', 'ruc', $this->ruc]);

        return $dataProvider;
    }
}
