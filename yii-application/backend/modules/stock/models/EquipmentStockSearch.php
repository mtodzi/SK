<?php

namespace backend\modules\stock\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\stock\models\EquipmentStock;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class EquipmentStockSearch extends EquipmentStock
{
    

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
    public function search($params,$id)
    {
        $query = EquipmentStock::find()->where(['stock_id'=>$id]);
        
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
    
    

}
