<?php
namespace backend\modules\orders\models;

use yii\base\Model;
use Yii;
use backend\modules\orders\models\Clients;


class SearchInputOrders extends Model
{
    //Задаем константы сценарияев для обработки форм
    const SCENARIO_CLIENTS_NAME = 'clients_name';//Сценарий обрабатывает поиск clients_name
    
    //Поля для обработки
    public $id_orders;
    public $clients_name;
    
    /**
     * @inheritdoc
     * Увязываем поля со сценариями
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CLIENTS_NAME => ['id_orders','clients_name'],  
        ];
    }
    
    /*
     *Задаем правила проверки полям      
     */
    public function rules()
    {
        return [
            ['id_orders', 'required'],
            [['id_orders'], 'integer'],
            
            ['clients_name', 'filter', 'filter' => 'trim'],
            ['clients_name', 'required'],

        ];
    }
    
    /*
     *Метод ишет клиентов по clients_name     
     */
    public function SearchClientsName(){
        $model_clients = Clients::find()->where(['LIKE', 'clients_name',($this->clients_name.'%'),FALSE])->all();
        if($model_clients !== NUll){
            return $model_clients;
        }else{
            return false;
        }
    } 
    
}


