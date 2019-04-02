<?php

namespace backend\modules\orders\models;

use Yii;
use yii\base\Model;
use backend\modules\orders\models\Clients;
use backend\modules\orders\models\ChangesTables;

class ClientsEdit extends Model{
    
    public $id_clients;
    public $clients_name;
    public $clients_email;
    public $clients_address;


    public function rules(){
        return [
            ['id_clients', 'required'],
            [['id_clients'], 'integer'],
            
            [['clients_name'], 'required'],
            [['clients_name'], 'string', 'max' => 50],
            
            [['clients_email'], 'required'],
            [['clients_email'], 'string', 'max' => 100],
            
            
            [['clients_address'], 'string', 'max' => 255],
        ];           
    }
    
    /*
     *Метод  сохраняет Клиента и возврашает его id для сохранения в заказе 
     */
    public function saveClients(){
        if($this->id_clients == 0){
            $modelClients = new Clients();
            $modelClients->clients_name = $this->clients_name;
            $modelClients->clients_email = $this->clients_email;
            $modelClients->clients_address = $this->clients_address;
            $modelClients->clients_archive = 0;
            if($modelClients->save()){
                $modelChangesTables = new ChangesTables('clients',$modelClients->id_clients,'Был создан новый клиент '.$modelClients->clients_name.' для заказ', Yii::$app->user->identity->id);
                $modelChangesTables->save();
                return $modelClients;
            }else{
                return null;
            }
        }else{
            $i = 0; //количество измененых полей в клиенте
            $modelClients = Clients::findOne($this->id_clients);
            if($modelClients !== null){
                $modelChangesСlients = 0;
                $modelChangesTablesEmail = 0;
                $modelChangesTablesAddress = 0;
                if(strcmp($modelClients->clients_name , $this->clients_name)!== 0){
                    $i++;
                    $nameKlient = $modelClients->clients_name;
                    $modelClients->clients_name = $this->clients_name;
                    $modelChangesСlients = new ChangesTables('clients',$modelClients->id_clients,'При работе с заказом был изменен ФИО клиента было - '.$nameKlient.'стало - '.$this->clients_name, Yii::$app->user->identity->id);
                }
                if(strcmp($modelClients->clients_email , $this->clients_email)!== 0){
                    $i++;
                    $emailKlient = $modelClients->clients_email;
                    $modelClients->clients_email = $this->clients_email;
                    $modelChangesTablesEmail = new ChangesTables('clients',$modelClients->id_clients,'При работе с заказом был изменен email клиента было - '.$emailKlient.'стало - '.$this->clients_email, Yii::$app->user->identity->id);
                }
                if(strcmp($modelClients->clients_address , $this->clients_address)!== 0){
                    $i++;
                    $clientsAddress = $modelClients->clients_address;
                    $modelClients->clients_address = $this->clients_address;
                    $modelChangesTablesAddress = new ChangesTables('clients',$modelClients->id_clients,'При работе с заказом был изменен адресс клиента было - '.$emailKlient.'стало - '.$this->clients_email, Yii::$app->user->identity->id);
                }
                if($i!=0){
                    if($modelClients->save()){
                        if(!empty($modelChangesСlients)){
                            $modelChangesСlients->save();
                        }
                        if(!empty($modelChangesTablesEmail)){
                            $modelChangesTablesEmail->save();
                        }
                        if(!empty($modelChangesTablesAddress)){
                            $modelChangesTablesAddress->save();
                        }
                        return $modelClients;
                    }else{
                        return null;
                    }
                }else{
                    return $modelClients;
                }
            }
        }
    }

    //Метод возврашает русские лейбы полей обьекта
    public function attributeLabels() {
        return
        [
            'id_clients'=>'Ключ клиента',
            'clients_name'=>'ФИО клиента', 
            'clients_email'=>'адрес электронной почты',
            'clients_address'=>'домашний адрес',
        ];
    }
}
