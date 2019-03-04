<?php
namespace backend\modules\orders\models;

use yii\base\Model;
use Yii;
use backend\modules\orders\models\Clients;
use backend\modules\orders\models\ClientsPhones;
use backend\modules\orders\models\Brands;
use backend\modules\orders\models\DeviceType;


class SearchInputOrders extends Model
{
    //Задаем константы сценарияев для обработки форм
    const SCENARIO_CLIENTS_NAME = 'clients_name';//Сценарий обрабатывает поиск clients_name
    const SCENARIO_PHONE = 'phone';//Сценарий обрабатывает поиск телефонам
    const SCENARIO_EMAIL = 'email';//Сценарий обрабатывает поиск email
    const SCENARIO_BREND = 'brend';//Сценарий обрабатывает поиск по brend
    const SCENARIO_DEVICE_TYPE = 'device_type';//Сценарий обрабатывает поиск по device_type
    
    //Поля для обработки
    public $id_orders;
    public $clients_name;
    public $phone_number;
    public $clients_email;
    public $brand_name;
    public $device_type;

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
            self::SCENARIO_BREND => ['id_orders','brand_name'],
            self::SCENARIO_DEVICE_TYPE => ['id_orders','device_type'],
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
            
            ['brand_name', 'filter', 'filter' => 'trim'],
            ['brand_name', 'required'],
            
            ['device_type', 'filter', 'filter' => 'trim'],
            ['device_type', 'required'],
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
    
    /*
     *Метод ишет клиентов по clients_email     
     */
    public function SearchBrandName(){
        $model_brend = Brands::find()->where(['LIKE', 'name_brands',($this->brand_name.'%'),FALSE])->all();
        if($model_brend !== NUll){
            return $model_brend;
        }else{
            return false;
        }
    }
    
    /*
     *Метод ишет клиентов по device_type    
     */
    public function SearchDeviceType(){
        $model_device_type = DeviceType::find()->where(['LIKE', 'device_type_name',($this->device_type.'%'),FALSE])->all();
        if($model_device_type !== NUll){
            return $model_device_type;
        }else{
            return false;
        }
    }
    
}


