<?php

namespace backend\modules\orders\models;

use yii\base\Model;

class OrdersEdit extends Model {
    
    public $id_orders;
    public $clients_id;


    public function rules(){
        return [
            ['id_orders', 'required'],
            [['id_orders'], 'integer'],
            
            ['clients_id', 'required'],
            [['clients_id'], 'integer'],
        ];           
    }
    
}
