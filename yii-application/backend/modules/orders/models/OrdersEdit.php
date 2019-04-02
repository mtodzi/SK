<?php

namespace backend\modules\orders\models;

use Yii;
use yii\base\Model;
use backend\modules\orders\models\Orders;
use backend\modules\orders\models\ChangesTables;

class OrdersEdit extends Model {
    
    public $id_orders;
    public $clients_id;
    public $repair_type;
    public $serrial_nambers_id;
    public $appearance;
    public $user_engener_id;
    public $urgency;
    public $special_notes;


    public function rules(){
        return [
            ['id_orders', 'required'],
            [['id_orders'], 'integer'],
            
            ['clients_id', 'required'],
            [['clients_id'], 'integer'],
            
            ['repair_type', 'required'],
            [['repair_type'], 'integer'],
            
            ['serrial_nambers_id', 'required'],
            [['serrial_nambers_id'], 'integer'],
            
            ['appearance', 'required'],
            [['appearance'], 'string', 'max' => 255],
            
            ['user_engener_id', 'required'],
            [['user_engener_id'], 'integer'],
            ['user_engener_id', 'compare', 'compareValue' => 0, 'operator' => '!=', 'type' => 'number','message' => 'Выберите инженера в заказе.'],
            
            ['urgency', 'required'],
            [['urgency'], 'integer'],
            
            [['special_notes'], 'string'],
        ];           
    }
    
    public function attributeLabels() {
        return
        [
            'id_orders'=>'Ключ заказа',
            'clients_id'=>'Ключ клиента',
            'repair_type'=>'тип ремонта', 
            'serrial_nambers_id'=>'Ключ продукта',
            'appearance'=>'внешний вид',
            'user_engener_id'=>'инженера для ремонта',
            'urgency'=>'срочность',
            'special_notes'=>'особые заметки',  
        ];
    }
    
    public function saveOrders($clients,$serrialNambers){
        if(!empty($clients) && !empty($serrialNambers)){
            if($this->id_orders == 0){
                $modelOrders = new Orders();
                $modelOrders->clients_id = $clients->id_clients;//
                $modelOrders->serrial_nambers_id = $serrialNambers->id_serial_numbers;//
                $modelOrders->repair_type = $this->repair_type;//
                $modelOrders->urgency = $this->urgency;//
                $modelOrders->user_engener_id = $this->user_engener_id;//
                $modelOrders->user_manager_id = Yii::$app->user->identity->id;//
                $modelOrders->archive = 0;//
                $modelOrders->appearance = $this->appearance;//
                $modelOrders->special_notes = $this->special_notes;//
                if($modelOrders->save()){
                    $modelChangesTables = new ChangesTables('orders',$modelOrders->id_orders,'Был создана новый заказ - '.$modelOrders->id_orders, Yii::$app->user->identity->id);
                    $modelChangesTables->save();
                    return $modelOrders;
                }else{
                    return null;
                }
            }else{
                $i=0;
                $modelChangesClients_id = 0;//
                $modelChangeSserrialNambers_id = 0;//
                $modelChangeRepairType = 0;//
                $modelChangeUrgency = 0;//
                $modelChangeUserEngener_id = 0;//
                $modelChangeUserManager_id = 0;//
                $modelChangeAppearance = 0;//
                $modelChangeSpecialNotes = 0;//
                $modelOrders = Orders::findOne($this->id_orders);
                if($modelOrders->clients_id != $clients->id_clients){//
                    $i++;
                    $Oclients_id = $modelOrders->clients_id;
                    $modelOrders->clients_id = $clients->id_clients;
                    $modelChangesClients_id = new ChangesTables('orders',$modelOrders->id_orders,'При работе с заказом был изменен id клиента было - '.$Oclients_id.'стало - '.$clients->id_clients, Yii::$app->user->identity->id);
                }
                if($modelOrders->serrial_nambers_id != $serrialNambers->id_serial_numbers){//
                    $i++;
                    $Oserrial_nambers_id = $modelOrders->serrial_nambers_id;
                    $modelOrders->serrial_nambers_id = $serrialNambers->id_serial_numbers;
                    $modelChangeSserrialNambers_id = new ChangesTables('orders',$modelOrders->id_orders,'При работе с заказом был изменен id серийного номера было - '.$Oserrial_nambers_id.'стало - '.$serrialNambers->id_serial_numbers, Yii::$app->user->identity->id);
                }
                if($modelOrders->repair_type != $this->repair_type){//
                    $i++;
                    $ArrayRepair_type = array(0=>"Ничего не делать",1=>"Диагностика",2=>"Ремонт",3=>"Диагностика и ремонт");
                    $Orepair_type = $modelOrders->repair_type;
                    $modelOrders->repair_type = $this->repair_type;
                    $modelChangeRepairType = new ChangesTables('orders',$modelOrders->id_orders,'При работе с заказом был изменен тип ремонта было - '.$ArrayRepair_type[$Orepair_type].'стало - '.$ArrayRepair_type[$this->repair_type], Yii::$app->user->identity->id);
                }
                if($modelOrders->urgency != $this->urgency){//
                    $i++;
                    $ArrayUrgency = array(0=>"не срочно",1=>"срочно");
                    $Ourgency = $modelOrders->urgency;
                    $modelOrders->urgency = $this->urgency;
                    $modelChangeUrgency = new ChangesTables('orders',$modelOrders->id_orders,'При работе с заказом был изменен тип ремонта было - '.$ArrayUrgency[$Ourgency].'стало - '.$ArrayUrgency[$this->urgency], Yii::$app->user->identity->id);
                }
                if($modelOrders->user_engener_id != $this->user_engener_id){//
                    $i++;
                    $OUserEngenerName = $modelOrders->userEngener->employeename;
                    $modelOrders->user_engener_id = $this->user_engener_id;
                    $modelChangeUserEngener_id = new ChangesTables('orders',$modelOrders->id_orders,'При работе с заказом был изменен инженер был - '.$OUserEngenerName.'стал - '.$modelOrders->userEngener->employeename, Yii::$app->user->identity->id);
                }
                if($modelOrders->user_manager_id != Yii::$app->user->identity->id){//
                    $i++;
                    $OUserManagerName = $modelOrders->userManager->employeename;
                    $modelOrders->user_manager_id = Yii::$app->user->identity->id;
                    $modelChangeUserManager_id = new ChangesTables('orders',$modelOrders->id_orders,'При работе с заказом изменения вносил новый менеджер был - '.$OUserEngenerName.'стал - '.$modelOrders->userEngener->employeename, Yii::$app->user->identity->id);
                }
                if(strcmp($modelOrders->appearance , $this->appearance)!== 0){//
                    $i++;
                    $OAppearance = $modelOrders->appearance;
                    $modelOrders->appearance = $this->appearance;
                    $modelChangeAppearance = new ChangesTables('orders',$modelOrders->id_orders,'При работе с заказом был изменен внешний вид устройства было - '.$OAppearance.'стало - '.$this->appearance, Yii::$app->user->identity->id);
                }
                if(strcmp($modelOrders->special_notes , $this->special_notes)!== 0){//
                    $i++;
                    $OSpecialNotes = $modelOrders->special_notes;
                    $modelOrders->special_notes = $this->special_notes;
                    $modelChangeSpecialNotes = new ChangesTables('orders',$modelOrders->id_orders,'При работе с заказом были изменены особые заметки было - '.$OSpecialNotes.'стало - '.$this->special_notes, Yii::$app->user->identity->id);
                }
                if($i!=0){
                    if($modelOrders->save()){
                        if(!empty($modelChangesClients_id)){
                           $modelChangesClients_id->save();
                        }
                        if(!empty($modelChangeSserrialNambers_id)){
                           $modelChangeSserrialNambers_id->save();
                        }
                        if(!empty($modelChangeRepairType)){
                           $modelChangeRepairType->save();
                        }
                        if(!empty($modelChangeUrgency)){
                           $modelChangeUrgency->save();
                        }
                        if(!empty($modelChangeUserEngener_id)){
                           $modelChangeUserEngener_id->save();
                        }
                        if(!empty($modelChangeUserManager_id)){
                           $modelChangeUserManager_id->save();
                        }
                        if(!empty($modelChangeAppearance)){
                           $modelChangeAppearance->save();
                        }
                        if(!empty($modelChangeSpecialNotes)){
                           $modelChangeSpecialNotes->save();
                        }
                        return $modelOrders;
                    }else{
                        return null;
                    }
                }else{
                    return $modelOrders;
                }
            }    
        }else{
            return null;
        }
    }
    
}
