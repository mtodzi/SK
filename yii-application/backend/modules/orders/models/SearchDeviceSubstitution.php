<?php
namespace backend\modules\orders\models;

use yii\base\Model;
use Yii;
use backend\modules\orders\models\Devices;
use backend\modules\orders\models\Orders;

class SearchDeviceSubstitution extends Model
{     
    //Поля для обработки
    public $id_orders;
    public $id_devices;
        
    /*
     *Задаем правила проверки полям      
     */
    public function rules()
    {
        return [
            ['id_orders', 'required'],
            [['id_orders'], 'integer'],
            
             ['id_devices', 'required'],
            [['id_devices'], 'integer'],

        ];
    }
    
    /*
     *Метод ишет клиента     
     */
    public function SearchDevices(){
        $model_devices = Devices::findOne($this->id_devices);
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

