<?php
namespace backend\modules\orders\models;

use yii\base\Model;
use Yii;
use backend\modules\orders\models\Brands;
use backend\modules\orders\models\Orders;

class SearchBrendSubstitution extends Model
{     
    //Поля для обработки
    public $id_orders;
    public $id_brand;
        
    /*
     *Задаем правила проверки полям      
     */
    public function rules()
    {
        return [
            ['id_orders', 'required'],
            [['id_orders'], 'integer'],
            
             ['id_brand', 'required'],
            [['id_brand'], 'integer'],

        ];
    }
    
    /*
     *Метод ишет клиента     
     */
    public function SearchBrand(){
        $model_clients = Brands::findOne($this->id_brand);
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

