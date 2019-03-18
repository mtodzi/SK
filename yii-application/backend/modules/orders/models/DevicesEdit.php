<?php
namespace backend\modules\orders\models;

use yii\base\Model;

class DevicesEdit extends Model{
    public $id_devices;
    public $devices_model;
    
    public function rules()
    {
        return [
            [['id_devices'], 'required'],
            [['id_devices'], 'integer'],
            
            [['devices_model'], 'required'],
            [['devices_model'], 'string', 'max' => 255],            
        ];
    }
    
    //Метод возврашает русские лейбы полей обьекта
    public function attributeLabels() {
        return
        [
            'id_devices'=>'Ключ модели устройства',
            'devices_model'=>'Модель устройства',            
        ];
    }
}
