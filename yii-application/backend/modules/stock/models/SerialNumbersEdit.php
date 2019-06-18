<?php
namespace backend\modules\stock\models;

use Yii;
use yii\base\Model;
use backend\modules\stock\models\SerialNumbers;
use backend\modules\stock\models\ChangesTables;

class SerialNumbersEdit extends Model{
    
    const SCENARIO_SEREIAL_NUMBERS_ONE = 'sereial_numbers_one';//Сценарий обрабатывает проверку по серийному номеру когда один номер
    const SCENARIO_SEREIAL_NUMBERS_RANGE = 'sereial_numbers_range';//Сценарий обрабатывает проверку по серийному номеру когда диопозон
    const SCENARIO_SEREIAL_NUMBERS_SOME = 'sereial_numbers_some';//Сценарий обрабатывает проверку по серийному номеру когда множество разных серийных номеров
    
    public $id_serial_numbers;
    public $serial_numbers_name;
    public $serial_numbers_start_range;
    public $serial_numbers_end_range;
    public $serial_numbers_name_array = array();
    public $id_serial_numbers_array = array();

    /**
     * @inheritdoc
     * Увязываем поля со сценариями
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_SEREIAL_NUMBERS_ONE => ['id_serial_numbers','serial_numbers_name'],
            self::SCENARIO_SEREIAL_NUMBERS_RANGE => ['serial_numbers_name','serial_numbers_start_range','serial_numbers_end_range'],
            self::SCENARIO_SEREIAL_NUMBERS_SOME => ['serial_numbers_name_array','id_serial_numbers_array'],
        ];
    }

    public function rules()
    {
        return [
            [['id_serial_numbers'], 'required'],
            [['id_serial_numbers'], 'integer'],
            
            [['serial_numbers_start_range'], 'required'],
            [['serial_numbers_start_range'], 'integer'],
            
            [['serial_numbers_end_range'], 'required'],
            [['serial_numbers_end_range'], 'integer'],
            
            [['serial_numbers_name'], 'required'],
            [['serial_numbers_name'], 'string', 'max' => 255],
            
            ['serial_numbers_name_array', 'each', 'rule' => ['required','message' => 'Один или более серийный номер пуст']],
            ['serial_numbers_name_array', 'each', 'rule' => ['string', 'max' => 255 ,'message' => 'Вы ввели один или несколько недопустимых по размеру букв серийных номеров']],
            ['serial_numbers_name_array','validateSerialNumbersCompare'],
            
            ['id_serial_numbers_array', 'each', 'rule' => ['required']],
            ['id_serial_numbers_array', 'each', 'rule' => ['integer']],
            
        ];
    }
    
    /*
     *Метод проверяет совпадают ли Серийные номера
     *
     */
    public function validateSerialNumbersCompare($attribute, $params)
    {
        $i = 0;
        foreach ($this->serial_numbers_name_array as $data){
            if($i == 0){
                $test = $data;                
            }else{
                if(strcasecmp($test,$data)== 0){
                    $this->addError($attribute, 'Один из введенных Серийных номеров совпадает');
                }
            }
            $i++;
        }
    }
    
    public function saveSerialNambers($devise){
        if(!empty($devise)){
            if($this->id_serial_numbers == 0){
                $modelSerialNambers = new SerialNumbers();
                $modelSerialNambers->serial_numbers_name = $this->serial_numbers_name;
                $modelSerialNambers->devise_id = $devise->id_devices;
                if($modelSerialNambers->save()){
                    $modelChangesTables = new ChangesTables('serial_numbers',$modelSerialNambers->id_serial_numbers,'Был создана новый серийный номер для склада - '.$modelSerialNambers->serial_numbers_name, Yii::$app->user->identity->id);
                    $modelChangesTables->save();
                    return array('errror'=>0,'msg'=>$modelSerialNambers);
                }else{
                    return array('errror'=>1,'msg'=>'Устройство с новым серийным номером не было создано в БД обратитесь к админу');
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
                        $modelChangesDeviceTypeName = new ChangesTables('serial_number',$modelSerialNambers->id_serial_numbers,'При работе со складом было изменено имя серийного номера было - '. $SerialNumbersName.'стало - '.$this->serial_numbers_name, Yii::$app->user->identity->id);
                    }
                    if($modelSerialNambers->devise_id != $devise->id_devices){
                        $i++;
                        $SerialNumbersDevise_id = $modelSerialNambers->devise_id;
                        $modelSerialNambers->devise_id = $devise->id_devices;
                        $modelChangesSserialNumbersDevise_id = new ChangesTables('serial_number',$modelSerialNambers->id_serial_numbers,'При работе со складом был изменен id модели было - '.$SerialNumbersDevise_id.'стало - '.$devise->id_devices, Yii::$app->user->identity->id);
                    }
                    if($i!=0){
                        if($modelSerialNambers->save()){
                            if(!empty($modelChangesDeviceTypeName)){
                                $modelChangesDeviceTypeName->save();
                            }
                            if(!empty($modelChangesSserialNumbersDevise_id)){
                                $modelChangesSserialNumbersDevise_id->save();
                            }
                            return array('errror'=>0,'msg'=>$modelSerialNambers);
                        }else{
                            return array('errror'=>1,'msg'=>'Серийный номер устройства не был изменен в БД обратитесь к админу');
                        }
                    }else{
                        return array('errror'=>0,'msg'=>$modelSerialNambers);
                    }
                }else{
                    return array('errror'=>1,'msg'=>'Серийный номер устройства не найден в БД обратитесь к админу');
                }
            }
        }else{
            return array('errror'=>1,'msg'=>'Устройство не было правильно передано в метод обратитесь к админу');
        }
    }

    public function attributeLabels() {
        return
            [
                'id_serial_numbers'=>'Ключ серийного номера',
                'serial_numbers_name'=>'Серийный номер',  
                'serial_numbers_start_range'=>'Начало диапазона',
                'serial_numbers_end_range'=>'Конец диапазона',
            ];
    }
}
