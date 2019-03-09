<?php
namespace backend\modules\orders\models;

use yii\base\Model;
use Yii;
use backend\modules\orders\models\Clients;
use backend\modules\orders\models\ClientsPhones;
use backend\modules\orders\models\Brands;
use backend\modules\orders\models\DeviceType;
use backend\modules\orders\models\Devices;
use backend\modules\orders\models\SerialNumbers;


class SearchInputOrders extends Model
{
    //Задаем константы сценарияев для обработки форм
    const SCENARIO_CLIENTS_NAME = 'clients_name';//Сценарий обрабатывает поиск clients_name
    const SCENARIO_PHONE = 'phone';//Сценарий обрабатывает поиск телефонам
    const SCENARIO_EMAIL = 'email';//Сценарий обрабатывает поиск email
    const SCENARIO_BREND = 'brend';//Сценарий обрабатывает поиск по brend
    const SCENARIO_DEVICE_TYPE = 'device_type';//Сценарий обрабатывает поиск по device_type
    const SCENARIO_DEVICES_MODEL = 'devices_model';//Сценарий обрабатывает поиск по devices_model
    const SCENARIO_SEREIAL_NUMBERS = 'sereial_numbers';//Сценарий обрабатывает поиск по sereial_numbers
    
    //Поля для обработки
    public $id_orders;
    public $clients_name;
    public $phone_number;
    public $clients_email;
    public $brand_name;
    public $device_type;
    public $brands_id;
    public $devices_type_id;
    public $devices_model;
    public $devise_id;
    public $serial_numbers_name;

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
            self::SCENARIO_DEVICES_MODEL => ['id_orders','brands_id','devices_type_id','devices_model'],
            self::SCENARIO_SEREIAL_NUMBERS => ['id_orders','devise_id','serial_numbers_name'],
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
            
            ['brands_id', 'required'],
            [['brands_id'], 'integer'],
            
            ['devices_type_id', 'required'],
            [['devices_type_id'], 'integer'],
            
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
            
            ['devices_model', 'filter', 'filter' => 'trim'],
            ['devices_model', 'required'],
            
            ['devise_id', 'required'],
            [['devise_id'], 'integer'],
            
            ['serial_numbers_name', 'filter', 'filter' => 'trim'],
            ['serial_numbers_name', 'required'],
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
    
    /*
     *Метод ишет клиентов по device_type    
     */
    public function SearchDevicesModel(){
        if($this->brands_id == 0 && $this->devices_type_id == 0){
            $model_devices_model = Devices::find()->where(['LIKE', 'devices_model',($this->devices_model.'%'),FALSE])->all();
        }
        
        if($this->brands_id == 0 && $this->devices_type_id!=0){
            $model_devices_model = Devices::find()->where(['AND',['=','devices_type_id', $this->devices_type_id],['LIKE', 'devices_model',($this->devices_model.'%'),FALSE]])->all();
        }
        if($this->brands_id != 0 && $this->devices_type_id == 0){
            $model_devices_model = Devices::find()->where(['AND',['=','brands_id', $this->brands_id],['LIKE', 'devices_model',($this->devices_model.'%'),FALSE]])->all();
        }
        if($this->brands_id != 0 && $this->devices_type_id != 0){
            $model_devices_model = Devices::find()->where(['AND',['=','brands_id', $this->brands_id],['=','devices_type_id', $this->devices_type_id],['LIKE', 'devices_model',($this->devices_model.'%'),FALSE]])->all();
        }
        if($model_devices_model !== NUll){
            return $model_devices_model;
        }else{
            return false;
        }
    }
    
    /*
     *Метод ишет клиентов по serial_numbers_name   
     */
    public function SearchSerialNnumbersName(){
        if($this->devise_id==0){
            $model_serial_numbers_name = SerialNumbers::find()->where(['LIKE', 'serial_numbers_name',($this->serial_numbers_name.'%'),FALSE])->all();
        }else{
            $model_serial_numbers_name = SerialNumbers::find()->where(['AND',['=','devise_id', $this->devise_id],['LIKE', 'serial_numbers_name',($this->serial_numbers_name.'%'),FALSE]])->all();
        }        
        if($model_serial_numbers_name !== NUll){
            return $model_serial_numbers_name;
        }else{
            return false;
        }
    }
    
}


