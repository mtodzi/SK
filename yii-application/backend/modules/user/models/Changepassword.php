<?php
namespace backend\modules\user\models;

use common\models\User;
use yii\base\Model;
use Yii;

class Changepassword extends Model
{
    public $password;
    public $prePassword;
    public $id;


    public function rules()
    {
    return [
            ['id', 'safe'],
        
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            
            ['prePassword', 'required'],
            ['prePassword', 'string', 'min' => 6],
            ['prePassword', 'compare', 'compareAttribute'=>'password', 'message'=>'Пароли не совпадают' ],
    ];}
    
    public function attributeLabels() {
        return
        [
            
            'password'=>'Пароль',
            'prePassword'=>'Проверочный пароль'
        ];
    }
    public function signup()
    {
        if ($this->validate()) {
            if (($model = User::findOne($this->id)) !== null) {
                $model->setPassword($this->password);
                if ($model->save()) {
                return $model;
                }
                
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

      
    }
    
    
}

