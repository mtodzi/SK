<?php

namespace backend\modules\orders\models;

use yii\base\Model;

class MalfunctionEdit extends Model{

    public $malfunction = array();
    public $claimed_malfunction_id = array();
    
    public function rules(){
        return [
            ['malfunction', 'each', 'rule' => ['required','message' => 'Одна или более введенная заявленная неисправность пуста.']],
            ['malfunction', 'each', 'rule' => ['string', 'max' => 255 ,'message' => 'Вы неправильно ввели один или более заявленных неисправностей.']],
            ['malfunction','validateMalfunctionCompare'],
            
            ['claimed_malfunction_id', 'each', 'rule' => ['required']],
            ['claimed_malfunction_id', 'each', 'rule' => ['integer']],
        ];           
    }
    
    /*
     *Метод проверяет совпадают ли телефоны
     *
     */
    public function validateMalfunctionCompare($attribute, $params)
    {
        $i = 0;
        foreach ($this->malfunction as $data){
            if($i == 0){
                $test = $data;                
            }else{
                if(strcasecmp($test,$data)== 0){
                    $this->addError($attribute, 'Одна из введенных заявленных неисправностей совпадает.');
                }
            }
            $i++;
        }
    }
    
    public function attributeLabels() {
        return
        [
            'claimed_malfunction_id'=>'Ключ заявленной неисправности',
            'malfunction'=>'Заявленная неисправность',            
        ];
    }
    
}
