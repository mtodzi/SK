<?php
namespace backend\modules\stock\models;

use Yii;
use yii\base\Model;
use backend\modules\stock\models\Devices;
use backend\modules\stock\models\ChangesTables;

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
    
    //Метод сохраняет и создает новую модель устройства 
    public function saveDevices($brand,$devices_type){
        if(!empty($brand) && !empty($devices_type)){
            if($this->id_devices == 0){
                $modelDevices = new Devices();
                $modelDevices->brands_id = $brand->id_brands;
                $modelDevices->devices_type_id = $devices_type->id_device_type;
                $modelDevices->devices_model = $this->devices_model;
                if($modelDevices->save()){
                    $modelChangesTables = new ChangesTables('devices',$modelDevices->id_devices,'Был создана новая модель устройства - '.$modelDevices->devices_model, Yii::$app->user->identity->id);
                    $modelChangesTables->save();
                    return $modelDevices;
                }else{
                    return null;
                }
            }else{
                $i = 0; //количество измененых полей в клиенте
                $modelChangesDeviceName = 0;
                $modelChangesDeviceBrands_id = 0;
                $modelChangesDeviceDevicesType_id = 0;
                $modelDevices = Devices::findOne($this->id_devices);
                if($modelDevices !== null){
                    if(strcmp($modelDevices->devices_model , $this->devices_model)!== 0){
                        $i++;
                        $DeviceModel = $modelDevices->devices_model;
                        $modelDevices->devices_model = $this->devices_model;
                        $modelChangesDeviceTypeName = new ChangesTables('devices',$modelDevices->id_devices,'При работе с заказом был изменено имя модели устройсва было - '.$DeviceModel.'стало - '.$this->devices_model, Yii::$app->user->identity->id);
                    }
                    if($modelDevices->brands_id != $brand->id_brands){
                        $i++;
                        $DeviceModelBrands_id = $modelDevices->brands_id;
                        $modelDevices->brands_id = $brand->id_brands;
                        $modelChangesDeviceBrands_id = new ChangesTables('devices',$modelDevices->id_devices,'При работе с заказом был изменен id бренда модели было - '.$DeviceModelBrands_id.'стало - '.$brand->id_brands, Yii::$app->user->identity->id);
                    }
                    if($modelDevices->devices_type_id != $devices_type->id_device_type){
                        $i++;
                        $DeviceModelDevicesType_id = $modelDevices->devices_type_id;
                        $modelDevices->devices_type_id = $devices_type->id_device_type;
                        $modelChangesDevicesType_id = new ChangesTables('devices',$modelDevices->id_devices,'При работе с заказом был изменен id типа модели было - '.$DeviceModelDevicesType_id.'стало - '.$devices_type->id_device_type, Yii::$app->user->identity->id);
                    }
                    if($i!=0){
                        if($modelDevices->save()){
                            if(!empty($modelChangesDeviceName)){
                                $modelChangesDeviceName->save();
                            }
                            if(!empty($modelChangesDeviceBrands_id)){
                                $modelChangesDeviceBrands_id->save();
                            }
                            if(!empty($DeviceModelDevicesType_id)){
                                $DeviceModelDevicesType_id->save();
                            }
                            return $modelDevices;
                        }else{
                            return null;
                        }
                    }else{
                        return $modelDevices;
                    }
                }else{
                    return null;
                }
            }
        }else{
            return null;
        }
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
