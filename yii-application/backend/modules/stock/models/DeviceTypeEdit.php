<?php
namespace backend\modules\stock\models;

use Yii;
use yii\base\Model;
use backend\modules\stock\models\DeviceType;
use backend\modules\stock\models\ChangesTables;

class DeviceTypeEdit extends Model{
    public $id_device_type;
    public  $device_type_name;
    
    public function rules()
    {
        return [
            
            [['id_device_type'], 'required'],
            [['id_device_type'], 'integer'],
            
            [['device_type_name'], 'required'],
            [['device_type_name'], 'string', 'max' => 255],
        ];
    }
    
    //Метод сохраняет и возврашает обьект DeviceType
    public function saveDeviceType(){
        if($this->id_device_type == 0){
            $modelDeviceType = new DeviceType();
            $modelDeviceType->id_device_type = $this->id_device_type;
            $modelDeviceType->device_type_name = $this->device_type_name;
            if($modelDeviceType->save()){
                $modelChangesTables = new ChangesTables('device_type',$modelDeviceType->id_device_type,'Был создан новый тип устройсва - '.$modelDeviceType->device_type_name, Yii::$app->user->identity->id);
                $modelChangesTables->save();
                return $modelDeviceType;
            }else{
                return null;
            }
        }else{
            $i = 0; //количество измененых полей в клиенте
            $modelChangesDeviceTypeName = 0;
            $modelDeviceType = DeviceType::findOne($this->id_device_type);
            if($modelDeviceType !== null){
                if(strcmp($modelDeviceType->device_type_name , $this->device_type_name)!== 0){
                    $i++;
                    $DeviceTypeName = $modelDeviceType->device_type_name;
                    $modelDeviceType->device_type_name = $this->device_type_name;
                    $modelChangesDeviceTypeName = new ChangesTables('device_type',$modelDeviceType->id_device_type,'При работе с заказом был изменено имя типа устройства было - '.$DeviceTypeName.'стало - '.$this->device_type_name, Yii::$app->user->identity->id);
                }
                if($i!=0){
                    if($modelDeviceType->save()){
                        if(!empty($modelChangesDeviceTypeNameё)){
                            $modelChangesDeviceTypeName->save();
                        }
                        return $modelDeviceType;
                    }else{
                        return null;
                    }
                }else{
                    return $modelDeviceType;
                }
            }else{
                return null;
            }
            
        }
    }


    //Метод возврашает русские лейбы полей обьекта
    public function attributeLabels() {
        return
        [
            'id_device_type'=>'Ключ типа устрайства',
            'device_type_name'=>'Тип устройства',            
        ];
    }
}
