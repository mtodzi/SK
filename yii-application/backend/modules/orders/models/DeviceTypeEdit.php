<?php
namespace backend\modules\orders\models;

use yii\base\Model;

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
}
