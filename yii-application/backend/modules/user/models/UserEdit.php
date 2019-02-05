<?php
namespace backend\modules\user\models;

use common\models\User;
use yii\base\Model;
use Yii;
use backend\modules\user\models\Position;


class UserEdit extends Model
{
    const SCENARIO_PASSWORD = 'password';
    const SCENARIO_NO_PASSWORD = 'nopassword';
    const SCENARIO_CREATE_NEW_USER = 'create_new_user';
    
    public $id;
    public $email;
    public $employeename;
    public $phone;
    public $address;
    public $password;
    public $prePassword;
    public $id_position;

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_PASSWORD => ['id','email','employeename','phone','address','password','prePassword','id_position'],
            self::SCENARIO_NO_PASSWORD => ['id','email','employeename','phone','address','id_position'],
            self::SCENARIO_CREATE_NEW_USER => ['email','employeename','phone','address','password','prePassword','id_position'],
        ];
    }
    
    public function rules()
    {
        return [
            ['id', 'required'],
            [['id'], 'integer'],
            
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот адрес электронной почты уже занят.'],
            
            ['employeename', 'filter', 'filter' => 'trim'],
            ['employeename', 'required'],
            ['employeename', 'string', 'max' => 255],
            
            
            ['phone', 'required'],
            ['phone', 'string', 'max' => 255],
            
            ['address', 'filter', 'filter' => 'trim'],
            ['address', 'required'],
            ['address', 'string', 'max' => 255],
            
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            
            ['prePassword', 'required'],
            ['prePassword', 'string', 'min' => 6],
            ['prePassword', 'compare', 'compareAttribute'=>'password', 'message'=>'Пароли не совпадают' ],
            
            [['id_position'], 'exist', 'skipOnError' => true, 'targetClass' => Position::className(), 'targetAttribute' => ['id_position' => 'id']],
            [['id_position'], 'integer'],
        ];
    }

    /**
     * Метод добавляет нового соьрудника в БД
     */
    public function create_new_user()
    {
        $user = new User();
        $user->email = $this->email;
        $user->employeename = $this->employeename;
        $user->phone = $this->phone;
        $user->address = $this->address;
        $user->id_position = $this->id_position;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if ($user->save()) {
            $arrayIdpositionRole = array(1=>'admin',2=>'manager',3=>'engineer');//Массив сопоставления id должности и роли
            $userAddRole = Yii::$app->authManager->getRole($arrayIdpositionRole[$this->id_position]);
            Yii::$app->authManager->assign($userAddRole, $user->id);
            return $user;
        }
        return false;
    }
    /*
     * Метод редоктирует сотрудника
     */
    public function update(){
        if (($user = User::findOne($this->id)) !== null) {
            $buferRole=0;//Переменная которая указывает нужно ли менять роль  сотрудника 0-нет 1-да
            $old_id_position=0;//переменная хранит id должности сотрудника до изменения 0 если измененй небыло
            $user->id = $this->id;
            $user->email = $this->email;
            $user->employeename = $this->employeename;
            $user->phone = $this->phone;
            $user->address = $this->address;
            if(!empty($this->password)){
                $user->setPassword($this->password);  
            }
            if($user->id_position != $this->id_position){                
                $buferRole=1;
                $old_id_position =  $user->id_position;
                $user->id_position = $this->id_position;        
            }    
            if ($user->save()){
                if($buferRole == 1){
                     $arrayIdpositionRole = array(1=>'admin',2=>'manager',3=>'engineer');//Массив сопоставления id должности и роли
                    //Удаляем роль у сотрудника
                    $userDeleteRole = Yii::$app->authManager->getRole($arrayIdpositionRole[$old_id_position]);
                    Yii::$app->authManager->revoke($userDeleteRole, $user->id);
                    //Добовляем роль сотруднику
                    $userAddRole = Yii::$app->authManager->getRole($arrayIdpositionRole[$this->id_position]);
                    Yii::$app->authManager->assign($userAddRole, $user->id);
                }
                return $user;
            }else{
                return FALSE;
            }
        } else {
            return FALSE;  
        }
        
    }

    public function attributeLabels() {
        return
        [
            'username'=>'Логин',
            'email'=>'Почта',
            'employeename'=>'ФИО',
            'phone'=>'Телефон',
            'password'=>'Пароль',
            'address'=>'Адрес',
            'prePassword'=>'Проверочный пароль',
            'id_position'=>'Должность'
        ];
    }
}
