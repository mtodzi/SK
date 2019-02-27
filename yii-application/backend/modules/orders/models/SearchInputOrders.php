<?php
namespace backend\modules\orders\models;

use yii\base\Model;
use Yii;
use backend\modules\orders\models\Clients;
use backend\modules\orders\models\ClientsPhones;


class SearchInputOrders extends Model
{
    //Задаем константы сценарияев для обработки форм
    const SCENARIO_CLIENTS_NAME = 'clients_name';//Сценарий обрабатывает поиск clients_name
    const SCENARIO_PHONE = 'phone';//Сценарий обрабатывает поиск телефонам
    const SCENARIO_EMAIL = 'email';//Сценарий обрабатывает поиск телефонам
    
    //Поля для обработки
    public $id_orders;
    public $clients_name;
    public $phone_number;
    public $clients_email;


    /**
     * @inheritdoc
     * Увязываем поля со сценариями
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CLIENTS_NAME => ['id_orders','clients_name'],  
            self::SCENARIO_PHONE => ['id_orders','phone_number'],
            self::SCENARIO_EMAIL => ['id_orders','clients_email'],
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
            
            ['phone_number', 'filter', 'filter' => 'trim'],
            ['phone_number', 'required'],

            ['clients_email', 'filter', 'filter' => 'trim'],
            ['clients_email', 'required'],
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
    
    /*
     *Метод ишет клиентов по телефонному номеру     
     */
    public function SearchPhoneNumber(){
        $model_phones = ClientsPhones::find()->where(['LIKE', 'phone_number',($this->phone_number.'%'),FALSE])->all();
        if($model_phones !== NUll){
            return $model_phones;
        }else{
            return false;
        }
    }
    
    /*
     *Метод ишет клиентов по clients_email     
     */
    public function SearchClientsEmail(){
        $model_clients = Clients::find()->where(['LIKE', 'clients_email',($this->clients_email.'%'),FALSE])->all();
        if($model_clients !== NUll){
            return $model_clients;
        }else{
            return false;
        }
    } 
    
}


