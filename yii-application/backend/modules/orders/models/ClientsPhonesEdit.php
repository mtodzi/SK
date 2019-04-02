<?php

namespace backend\modules\orders\models;

use Yii;
use yii\base\Model;
use backend\modules\orders\models\ClientsPhones;
use backend\modules\orders\models\ChangesTables;

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
    
    public function savePhoneClients($id_clients){
           $modelPhoneClients = ClientsPhones::findAll(['clients_id'=>$id_clients]);
           if($modelPhoneClients!==null){
                foreach ($this->phone_number as $data){
                    $i = 0;
                    foreach ($modelPhoneClients as $value){                         
                        if(strcmp($value->phone_number , $data)== 0){
                            $i++;
                        }
                    }
                    if($i==0){
                        $modelClientPhone = new ClientsPhones();
                        $modelClientPhone->clients_id = $id_clients;
                        $modelClientPhone->phone_number = $data;
                        if($modelClientPhone->save()){
                            $modelChangesTables = new ChangesTables('clients_phones',$modelClientPhone->clients_id,'Был создан новый телефон для клиента '.$modelClientPhone->clients->clients_name.' c номером '.$modelClientPhone->phone_number.' для заказ', Yii::$app->user->identity->id);
                            $modelChangesTables->save();
                        }
                        
                    }
                }
                $modelPhoneClients = ClientsPhones::findAll(['clients_id'=>$id_clients]);
                foreach ($modelPhoneClients as $value){
                    $i = 0;
                    foreach ($this->phone_number as $data){                        
                        if(strcmp($value->phone_number , $data)== 0){
                            $i++;
                        }
                    }
                    if($i==0){
                        $id_clients = $value->clients_id;
                        $phone_number = $value->phone_number;
                        ClientsPhones::deleteAll(['clients_id'=>$value->clients_id, 'phone_number'=>$value->phone_number]);
                        $modelChangesTables = new ChangesTables('clients_phones',$id_clients,'Был удален телефон клиента c номером '.$phone_number.' для заказ', Yii::$app->user->identity->id);
                        $modelChangesTables->save();
                        
                    }
                }
                return true;
            }else{
                foreach ($this->phone_number as $data){
                    $modelClientPhone = new ClientsPhones();
                    $modelClientPhone->clients_id = $id_clients;
                    $modelClientPhone->phone_number = $data;
                    if($modelClientPhone->save()){
                        $modelChangesTables = new ChangesTables('clients_phones',$modelClientPhone->clients_id,'Был создан новый телефон для клиента '.$modelClientPhone->clients->clients_name.' c номером '.$modelClientPhone->phone_number.' для заказ', Yii::$app->user->identity->id);
                        $modelChangesTables->save();
                    }
                    
                }
                return true;
            }    
        
    }


    //Метод возврашает русские лейбы полей обьекта
    public function attributeLabels() {
        return
        [
            'clients_id'=>'Ключ клиента',
            'phone_number'=>'Телефон',             
        ];
    }
    
}
