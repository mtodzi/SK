<?php

namespace backend\modules\orders\models;

use yii\base\Model;

class ClientsEdit extends Model{
    
    public $clients_id;
    public $clients_name;
    public $clients_email;
    public $clients_address;


    public function rules(){
        return [
            ['id_clients', 'required'],
            [['id_clients'], 'integer'],
            
            [['clients_name'], 'required'],
            [['clients_name'], 'string', 'max' => 50],
            
            [['clients_email'], 'required'],
            [['clients_email'], 'string', 'max' => 100],
            
            [['clients_email'], 'required'],
            [['clients_address'], 'string', 'max' => 255],
        ];           
    }
    
}
