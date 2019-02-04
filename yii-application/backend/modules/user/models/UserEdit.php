<?php
namespace backend\modules\user\models;

use common\models\User;
use yii\base\Model;
use Yii;
use backend\modules\user\models\Position;

/**
 * Signup form
 */
class UserEdit extends Model
{
    const SCENARIO_PASSWORD = 'password';
    const SCENARIO_NO_PASSWORD = 'nopassword';
    
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
            self::SCENARIO_PASSWORD => ['email','employeename','phone','address','password','prePassword','id_position'],
            self::SCENARIO_NO_PASSWORD => ['email','employeename','phone','address','id_position'],
        ];
    }
    
    public function rules()
    {
        return [
         
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
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->email = $this->email;
            $user->employeename = $this->employeename;
            $user->phone = $this->phone;
            $user->address = $this->address;
            $user->id_position = $this->id_position;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
    public function update(){
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->employeename = $this->employeename;
        $user->phone = $this->phone;
        $user->address = $this->address;
        $user->id_position = $this->id_position;
        if ($user->save()) {
                return $user;
            }
    }

    public function attributeLabels() {
        return
        [
            'username'=>'Логин',
            'email'=>'Почта Работника',
            'employeename'=>'ФИО Работника',
            'phone'=>'Телефон',
            'password'=>'Пароль',
            'address'=>'Адрес',
            'prePassword'=>'Проверочный пароль',
            'id_position'=>'Должность'
        ];
    }
}
