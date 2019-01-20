<?php
namespace backend\modules\user\models;

use Yii;
use yii\base\Model;
use common\models\User;

class AsktheEmployeeRole extends Model{
    public $role;
    public $id;
    
    public function rules()
    {
        return [
            // name, email, subject and body are required
            ['role', 'required'],
            //['role', 'validatenamerole'],
            
            ['id', 'safe'],
        ];
    }
   
    public function attributeLabels() {
        return [
            'role' => 'Роль', 
        ];
    }
    public function employeeRole(){
        if ($this->validate()) {
            $model = User::findOne($this->id);
            $userRole = Yii::$app->authManager->getRole($this->role);
            Yii::$app->authManager->assign($userRole, $model->id);
            return  $model;
            
        }
        
    }
    public function deleteRole(){
       if ($this->validate()) {
            $model = User::findOne($this->id);
            $userRole = Yii::$app->authManager->getRole($this->role);
            Yii::$app->authManager->revoke($userRole, $model->id);
            return  $model;
            
        } 
    }

    public function validatenamerole($attribute, $params){
        
        
           
        
    }
}
