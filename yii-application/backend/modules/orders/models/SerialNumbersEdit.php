<?php
namespace backend\modules\orders\models;

use yii\base\Model;

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
    
    public function attributeLabels() {
        return
        [
            'id_serial_numbers'=>'Ключ серийного номера',
            'serial_numbers_name'=>'серийный номер',            
        ];
    }
}
