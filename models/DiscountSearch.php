<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Discount;

/**
 * DiscountSearch represents the model behind the search form about `app\models\Discount`.
 */
class DiscountSearch extends Discount
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'birthdate_before', 'birthdate_after', 'phone_exists', 'phone_tail'], 'integer'],
            [['discount'], 'number'],
            [['gender'], 'safe'],
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
        $query = Discount::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],            
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
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
            'discount' => $this->discount,
            'birthdate_before' => $this->birthdate_before,
            'birthdate_after' => $this->birthdate_after,
            'phone_exists' => $this->phone_exists,
            'phone_tail' => $this->phone_tail,
            //'date_start' => $this->date_start,
            //'date_end' => $this->date_end,
            'gender'=>$this->gender
        ]);

        //$query->andFilterWhere(['like', 'gender', $this->gender]);

        return $dataProvider;
    }
}
