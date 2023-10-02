<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Distance;

/**
 * DistanceSearch represents the model behind the search form of `app\models\Distance`.
 */
class DistanceSearch extends Distance
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idDistance'], 'integer'],
            [['meters', 'kilometers'], 'safe'],
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
        $query = Distance::find();

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
            'idDistance' => $this->idDistance,
        ]);

        $query->andFilterWhere(['like', 'meters', $this->meters])
            ->andFilterWhere(['like', 'kilometers', $this->kilometers]);

        return $dataProvider;
    }
}
