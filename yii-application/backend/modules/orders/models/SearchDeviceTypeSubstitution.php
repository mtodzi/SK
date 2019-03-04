<?php
namespace backend\modules\orders\models;

use yii\base\Model;
use Yii;
use backend\modules\orders\models\DeviceType;
use backend\modules\orders\models\Orders;

class SearchDeviceTypeSubstitution extends Model
{     
    //Поля для обработки
    public $id_orders;
    public $id_device_type;
        
    /*
     *Задаем правила проверки полям      
     */
    public function rules()
    {
        return [
            ['id_orders', 'required'],
            [['id_orders'], 'integer'],
            
             ['id_device_type', 'required'],
            [['id_device_type'], 'integer'],

        ];
    }
    
    /*
     *Метод ишет клиента     
     */
    public function SearchDeviceType(){
        $model_device_type = DeviceType::findOne($this->id_device_type);
        if($model_device_type !== NUll){
            return $model_device_type;
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

