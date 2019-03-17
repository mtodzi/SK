<?php

namespace backend\modules\orders\models;

use yii\base\Model;

class ClientsPhonesEdit extends Model{

    public $phone_number = array();
    public $clients_id;
    
    public function rules(){
        return [
            ['phone_number', 'each', 'rule' => ['required','message' => 'Один или более введенный телефон пуст.']],
            ['phone_number', 'each', 'rule' => ['string', 'max' => 16 ,'message' => 'Вы неправильно ввели один или более телефонов.']],
            ['phone_number','validatePhoneCompare'],
            
            [['clients_id'], 'required'],
            [['clients_id'], 'integer'],
        ];           
    }
    
    /*
     *Метод проверяет совпадают ли телефоны
     *
     */
    public function validatePhoneCompare($attribute, $params)
    {
        $i = 1;
        foreach ($this->phone_number as $data){
            if($i == 1){
                $test = $data;                
            }else{
                if(strcasecmp($test,$data)== 0){
                    $this->addError($attribute, 'Один из введенных телефонов совпадает.');
                }
            }
            $i++;
        }
    }
    
}
