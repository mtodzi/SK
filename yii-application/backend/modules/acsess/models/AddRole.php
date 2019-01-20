<?php

namespace backend\modules\acsess\models;

use Yii;
use yii\base\Model;

class AddRole extends Model{
    
    public $name; //Имя добовляемой роли
    public $description; //Описание роли
    
    
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'description', ], 'required'],
            
            
            ['name', 'validatenamerole'],
            
            
        ];
    }
    
    
    
    public function validatenamerole($attribute, $params){
        
        $test = \Yii::$app->authManager->getRole($this->name);
            if(isset($test->name)){
               $this->addError($attribute, 'Такая роль уже существует');
            }
           
        
        /*
        $test = \Yii::$app->authManager->getRole($name);
        $this->addError($name, 'Такая роль уже существует'.$test->name);
        
        if(is_array(\Yii::$app->authManager->getRole($name))){
            $this->addError($name, 'Такая роль уже существует');
        }else{
             $this->addError($name, 'Такая роль уже не существует');
        }
         * 
         */
    }
    public function attributeLabels() {
        return [
            'name' => 'Роль',
            'description' => 'Описание Роли'
        ];
    }
    public function roleSave(){
        $role = Yii::$app->authManager->createRole($this->name);
        $role->description = $this->description;
        Yii::$app->authManager->add($role);
    }
    
}

