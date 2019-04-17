<?php

namespace backend\modules\orders\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\orders\models\Orders;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class OrdersSearch extends Orders
{
    public $search;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //['search','string','max' => 255],
            ['search','safe'],
            ['search', 'filter', 'filter' => 'trim'],
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
        $query = Orders::find()->where(['archive'=>0])->orderBy(['updated_at'=>SORT_DESC]);
        
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
        $query->joinWith('clients');
        $query->joinWith('serrialNambers');
        $query->andFilterWhere([
                'id_orders'=>$this->search,
            ]);
        $query->orFilterWhere(['=', 'clients_name', $this->search]);
        $query->orFilterWhere(['=', 'serial_numbers_name', $this->search]);
        
        /*
        if(is_numeric($this->search)){
            $query->andFilterWhere([
                'id_orders'=>$this->search,
            ]);
            return $dataProvider;
        }
        
        if(is_string($this->search) && !isset($this->search)){
            $query->joinWith('clients');
            //$query->join('INNER JOIN','clients_phones',['orders.clients_id'=>'clients_phones.clients_id']);
            $query->andFilterWhere(['=', 'clients_name', $this->search]);
            //$query->andFilterWhere(['=', 'clients_phones.phone_number', $this->search]);
            return $dataProvider;
        }
        
        $query->joinWith('clients');
        $query->join('LEFT JOIN','clients_phones',['orders.clients_id'=>'clients_phones.clients_id']);
        
        $query->andFilterWhere([
            'id_orders'=>$this->search,
        ]);
        $query->orFilterWhere(['=', 'clients_name', $this->search]);
        $query->orFilterWhere(['=', 'phone_number', $this->search]);
        //$query->andFilterWhere(['id_orders'=>$this->search]);
        
        $query->joinWith('position');
        
        $query->andFilterWhere(['like', 'email', $this->search]);
        $query->orFilterWhere(['like', 'employeename', $this->search]);
        $query->orFilterWhere(['like', 'address', $this->search]);
        $query->orFilterWhere(['like', 'phone', $this->search]);
        $query->orFilterWhere(['like', 'name_position', $this->search]);
        $query->andFilterWhere(['archive'=>0]);
        */
        return $dataProvider;
    }
    /*
    public function searchArchive($params)
    {
        $query = User::find()->where(['archive'=>1])->orderBy(['updated_at'=>SORT_DESC]);
        
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
       $query->joinWith('position');
        
        $query->andFilterWhere(['like', 'email', $this->search])
        ->orFilterWhere(['like', 'employeename', $this->search])
        ->orFilterWhere(['like', 'address', $this->search])
        ->orFilterWhere(['like', 'phone', $this->search])
        ->orFilterWhere(['like', 'name_position', $this->search]);
        $query->andFilterWhere(['archive'=>1]);
        return $dataProvider;
    }
     * 
     */
}
