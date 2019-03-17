<?php

namespace backend\modules\orders\models;

use yii\base\Model;

class OrdersEdit extends Model {
    
    public $id_orders;
    public $clients_id;
    public $repair_type; 


    public function rules(){
        return [
            ['id_orders', 'required'],
            [['id_orders'], 'integer'],
            
            ['clients_id', 'required'],
            [['clients_id'], 'integer'],
            
            ['repair_type', 'required'],
            [['repair_type'], 'integer'],
        ];           
    }
    
}
