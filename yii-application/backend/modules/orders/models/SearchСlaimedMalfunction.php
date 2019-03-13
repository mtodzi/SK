<?php
namespace backend\modules\orders\models;

use yii\base\Model;
use Yii;
use backend\modules\orders\models\ClaimedMalfunction;
use backend\modules\orders\models\Orders;

class SearchСlaimedMalfunction extends Model
{     
    //Поля для обработки
    public $id_orders;
    public $id_claimed_malfunction;
    public $id_malfunction_card;


    /*
     *Задаем правила проверки полям      
     */
    public function rules()
    {
        return [
            ['id_orders', 'required'],
            [['id_orders'], 'integer'],
            
            ['id_claimed_malfunction', 'required'],
            [['id_claimed_malfunction'], 'integer'],
            
            ['id_malfunction_card', 'required'],
            [['id_malfunction_card'], 'integer'],

        ];
    }
    
    /*
     *Метод ишет заявленную неисправность     
     */
    public function SearchСlaimedMalfunction(){
        $model_claimed_malfunction = ClaimedMalfunction::findOne($this->id_claimed_malfunction);
        if($model_claimed_malfunction !== NUll){
            return $model_claimed_malfunction;
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

