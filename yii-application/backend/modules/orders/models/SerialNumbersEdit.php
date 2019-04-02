<?php
namespace backend\modules\orders\models;

use Yii;
use yii\base\Model;
use backend\modules\orders\models\SerialNumbers;
use backend\modules\orders\models\ChangesTables;

class SerialNumbersEdit extends Model{
    public $id_serial_numbers;
    public $serial_numbers_name;
    
    public function rules()
    {
        return [
            [['id_serial_numbers'], 'required'],
            [['id_serial_numbers'], 'integer'],
            
            [['serial_numbers_name'], 'required'],
            [['serial_numbers_name'], 'string', 'max' => 255],         
        ];
    }
    
    public function saveSerialNambers($devise){
        if(!empty($devise)){
            if($this->id_serial_numbers == 0){
                $modelSerialNambers = new SerialNumbers();
                $modelSerialNambers->serial_numbers_name = $this->serial_numbers_name;
                $modelSerialNambers->devise_id = $devise->id_devices;
                if($modelSerialNambers->save()){
                    $modelChangesTables = new ChangesTables('serial_numbers',$modelSerialNambers->id_serial_numbers,'Был создана новый серийный номер - '.$modelSerialNambers->serial_numbers_name, Yii::$app->user->identity->id);
                    $modelChangesTables->save();
                    return $modelSerialNambers;
                }else{
                    return null;
                }
            }else{
                $i = 0; //количество измененых полей в клиенте
                $modelChangeSserialNumbersName = 0;
                $modelChangesSserialNumbersDevise_id = 0;
                $modelSerialNambers = SerialNumbers::findOne($this->id_serial_numbers);
                if($modelSerialNambers !== null){
                    if(strcmp($modelSerialNambers->serial_numbers_name , $this->serial_numbers_name)!== 0){
                        $i++;
                        $SerialNumbersName = $modelSerialNambers->serial_numbers_name;
                        $modelSerialNambers->serial_numbers_name = $this->serial_numbers_name;
                        $modelChangesDeviceTypeName = new ChangesTables('serial_number',$modelSerialNambers->id_serial_numbers,'При работе с заказом было изменено имя серийного номера было - '. $SerialNumbersName.'стало - '.$this->serial_numbers_name, Yii::$app->user->identity->id);
                    }
                    if($modelSerialNambers->devise_id != $devise->id_devices){
                        $i++;
                        $SerialNumbersDevise_id = $modelSerialNambers->devise_id;
                        $modelSerialNambers->devise_id = $devise->id_devices;
                        $modelChangesSserialNumbersDevise_id = new ChangesTables('serial_number',$modelSerialNambers->id_serial_numbers,'При работе с заказом был изменен id модели было - '.$SerialNumbersDevise_id.'стало - '.$devise->id_devices, Yii::$app->user->identity->id);
                    }
                    if($i!=0){
                        if($modelSerialNambers->save()){
                            if(!empty($modelChangesDeviceTypeName)){
                                $modelChangesDeviceTypeName->save();
                            }
                            if(!empty($modelChangesSserialNumbersDevise_id)){
                                $modelChangesSserialNumbersDevise_id->save();
                            }
                            return $modelSerialNambers;
                        }else{
                            return null;
                        }
                    }else{
                        return $modelSerialNambers;
                    }
                }else{
                    return null;
                }
            }
        }else{
            return null;
        }
    }

    public function attributeLabels() {
        return
            [
                'id_serial_numbers'=>'Ключ серийного номера',
                'serial_numbers_name'=>'серийный номер',            
            ];
        }
}
