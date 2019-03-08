<?php
namespace backend\modules\orders\models;

use yii\base\Model;
use Yii;
use backend\modules\orders\models\SerialNumbers;
use backend\modules\orders\models\Orders;

class SearchSerialNumbers extends Model
{     
    //Поля для обработки
    public $id_orders;
    public $id_serial_numbers;
        
    /*
     *Задаем правила проверки полям      
     */
    public function rules()
    {
        return [
            ['id_orders', 'required'],
            [['id_orders'], 'integer'],
            
             ['id_serial_numbers', 'required'],
            [['id_serial_numbers'], 'integer'],

        ];
    }
    
    /*
     *Метод ишет клиента     
     */
    public function SearchSerialNumbers(){
        $model_devices = SerialNumbers::findOne($this->id_serial_numbers);
        if($model_devices !== NUll){
            return $model_devices;
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

