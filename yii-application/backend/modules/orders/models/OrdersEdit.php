<?php

namespace backend\modules\orders\models;

use yii\base\Model;

class OrdersEdit extends Model {
    
    public $id_orders;
    public $clients_id;
    public $repair_type;
    public $serrial_nambers_id;
    public $appearance;
    public $user_engener_id;
    public $urgency;
    public $special_notes;


    public function rules(){
        return [
            ['id_orders', 'required'],
            [['id_orders'], 'integer'],
            
            ['clients_id', 'required'],
            [['clients_id'], 'integer'],
            
            ['repair_type', 'required'],
            [['repair_type'], 'integer'],
            
            ['serrial_nambers_id', 'required'],
            [['serrial_nambers_id'], 'integer'],
            
            ['appearance', 'required'],
            [['appearance'], 'string', 'max' => 255],
            
            ['user_engener_id', 'required'],
            [['user_engener_id'], 'integer'],
            ['user_engener_id', 'compare', 'compareValue' => 0, 'operator' => '!=', 'type' => 'number','message' => 'Выберите инженера в заказе.'],
            
            ['urgency', 'required'],
            [['urgency'], 'integer'],
        ];           
    }
    
    public function attributeLabels() {
        return
        [
            'id_orders'=>'Ключ заказа',
            'clients_id'=>'Ключ клиента',
            'repair_type'=>'тип ремонта', 
            'serrial_nambers_id'=>'Ключ продукта',
            'appearance'=>'внешний вид',
            'user_engener_id'=>'инженера для ремонта',
            'urgency'=>'срочность',
            'special_notes'=>'особые заметки',  
        ];
    }
    
}
