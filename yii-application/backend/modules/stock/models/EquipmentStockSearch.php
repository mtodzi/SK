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
    public $search;

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    
    public function rules()
    {
        return [
            //['search','string','max' => 255],
            ['search','safe'],
            ['search', 'filter', 'filter' => 'trim'],
        ];
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
        $query->joinWith('serialNumber');
        $query->joinWith('devices');
        $query->joinWith('brands');
        $query->joinWith('devicesType');
        
        $query->andFilterWhere(['=', 'serial_numbers_name', $this->search]);
        $query->orFilterWhere(['=', 'devices_model', $this->search]);
        $query->orFilterWhere(['=', 'name_brands', $this->search]);
        $query->orFilterWhere(['=', 'device_type_name', $this->search]);
        $query->andFilterWhere(['stock_id'=>$id]);
        
        return $dataProvider;
    }
    
    

}
