<?php
namespace backend\modules\orders\models;

use yii\base\Model;
use Yii;
use backend\modules\orders\models\Clients;
use backend\modules\orders\models\Orders;

class SearchClientsSubstitution extends Model
{     
    //Поля для обработки
    public $id_orders;
    public $id_clients;
        
    /*
     *Задаем правила проверки полям      
     */
    public function rules()
    {
        return [
            ['id_orders', 'required'],
            [['id_orders'], 'integer'],
            
             ['id_clients', 'required'],
            [['id_clients'], 'integer'],

        ];
    }
    
    /*
     *Метод ишет клиента     
     */
    public function SearchClients(){
        $model_clients = Clients::findOne($this->id_clients);
        if($model_clients !== NUll){
            return $model_clients;
        }else{
            return false;
        }
    }
    
    /*
     *Метод ишет заказ     
     */
    public function SearchOrders(){
        $model_order = Orders::findOne($this->id_orders);
        if($model_order !== NUll){
            return $model_order;
        }else{
            return false;
        }
    } 
    
}

