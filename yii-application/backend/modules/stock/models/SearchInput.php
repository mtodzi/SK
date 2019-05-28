<?php
namespace backend\modules\stock\models;

use yii\base\Model;
use Yii;

use backend\modules\stock\models\Brands;
use backend\modules\stock\models\DeviceType;
use backend\modules\stock\models\Devices;
use backend\modules\stock\models\SerialNumbers;


class SearchInput extends Model
{
    //Задаем константы сценарияев для обработки форм  
    const SCENARIO_BREND = 'brend';//Сценарий обрабатывает поиск по brend
    const SCENARIO_DEVICE_TYPE = 'device_type';//Сценарий обрабатывает поиск по device_type
    const SCENARIO_DEVICES_MODEL = 'devices_model';//Сценарий обрабатывает поиск по devices_model
    const SCENARIO_SEREIAL_NUMBERS = 'sereial_numbers';//Сценарий обрабатывает поиск по sereial_numbers
    
    //Поля для обработки
    public $id_serial_numbers;
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
            self::SCENARIO_BREND => ['id_serial_numbers','brand_name'],
            self::SCENARIO_DEVICE_TYPE => ['id_serial_numbers','device_type'],
            self::SCENARIO_DEVICES_MODEL => ['id_serial_numbers','brands_id','devices_type_id','devices_model'],
            self::SCENARIO_SEREIAL_NUMBERS => ['id_serial_numbers','devise_id','serial_numbers_name'],
        ];
    }
    
    /*
     *Задаем правила проверки полям      
     */
    public function rules()
    {
        return [

            ['id_serial_numbers', 'required'],
            [['id_serial_numbers'], 'integer'],
            
            ['brands_id', 'required'],
            [['brands_id'], 'integer'],
            
            ['devices_type_id', 'required'],
            [['devices_type_id'], 'integer'],
                        

            
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
     *Метод ишет имена брендов    
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
    
    /*
     *Метод ишет клиентов по claimed_malfunction_name    
     */
    public function SearchClaimedMalfunctionName(){
        $model_claimed_malfunction_name = ClaimedMalfunction::find()->where(['LIKE', 'claimed_malfunction_name',($this->claimed_malfunction_name.'%'),FALSE])->all();
        if($model_claimed_malfunction_name !== NUll){
            return $model_claimed_malfunction_name;
        }else{
            return false;
        }
    }
    
}


