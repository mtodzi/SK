<?php
namespace backend\modules\user\models;

use common\models\User;
use yii\base\Model;
use Yii;
use backend\modules\user\models\Position;


class UserEdit extends Model
{
    //Задаем константы сценарияев для обработки форм
    const SCENARIO_PASSWORD = 'password';//Сценарий обрабатывает редактирование сатрудника со сменой пароля
    const SCENARIO_NO_PASSWORD = 'nopassword';//Сценарий обрабатывает редактирование сотрудника без пароля
    const SCENARIO_CREATE_NEW_USER = 'create_new_user';//Сценарий обрабатывает создание сотрудника
    
    //Поля для обработки
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
     * Увязываем поля со сценариями
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_PASSWORD => ['id','email','employeename','phone','address','password','prePassword','id_position'],
            self::SCENARIO_NO_PASSWORD => ['id','email','employeename','phone','address','id_position'],
            self::SCENARIO_CREATE_NEW_USER => ['email','employeename','phone','address','password','prePassword','id_position'],
        ];
    }
    /*
     *Задаем правила проверки полям      
     */
    public function rules()
    {
        return [
            ['id', 'required'],
            [['id'], 'integer'],
            
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот адрес электронной почты уже занят.', 'on' => self::SCENARIO_CREATE_NEW_USER],
            ['email','validateEmailUpdate', 'on' => self::SCENARIO_NO_PASSWORD],
            ['email','validateEmailUpdate', 'on' => self::SCENARIO_PASSWORD],
            
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
            
            ['id_position','validateDirectorChange', 'on' => self::SCENARIO_NO_PASSWORD],
            ['id_position','validateDirectorChange', 'on' => self::SCENARIO_PASSWORD],
        ];
    }
    /*
     *Метод проверяет на уникальность изменяемый email при редактировании
     *
     */
    public function validateEmailUpdate($attribute, $params)
    {
        $model = User::findOne($this->id);//Находим сотрудника в Базе
        if($this->email != $model->email){//Проверяем меняем ли мы сотруднику email
            //если да
            $userEmail = User::findOne(['email'=>$this->$attribute]);//Ищем в БД совподаюший email
            if($userEmail != null){//если находим добавляем ощибку
                $this->addError($attribute, 'Этот адрес электронной почты уже занят.');
            }
        }
    }
    /*
     *Метод проверяет назначен ли допольнительно директор при смене директору должност 
     *
     */
    public function validateDirectorChange($attribute, $params)
    {
        $User = User::findOne($this->id);//Находим сотрудника в Базе
        if($User->id_position!= $this->id_position){//Проверяем меняем ли мы сотруднику должность
            if($User->id_position==1){//если да то проверяем назначена ли должность у него директор
                //если да
                //Подсчитываем сколько в БД сотрудников с должностью Директор
                $model = User::find()->where(['id_position'=> 1])->count();
                //Проверяем количество если равно 1 или меньше то возврашаем ошибку
                if($model<=1){                
                    $this->addError($attribute, 'Должен быть хотя бы один директор!');
                }
            }
        }    
    }

    /**
     * Метод добавляет нового соьрудника в БД
     */
    public function create_new_user()
    {
        $user = new User();//Создаем обьект USER
        //Присваеваем полям обьекта User поля нашего обьекта
        $user->email = $this->email;
        $user->employeename = $this->employeename;
        $user->phone = $this->phone;
        $user->address = $this->address;
        $user->id_position = $this->id_position;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if ($user->save()) {//Сохраняем нового Сотрудника в БД и проверяем сохранился ли он
            //если да
            $arrayIdpositionRole = array(1=>'admin',2=>'manager',3=>'engineer');//Массив сопоставления id должности и роли
            $userAddRole = Yii::$app->authManager->getRole($arrayIdpositionRole[$this->id_position]);//берем роль которая была выбрана сотруднику
            Yii::$app->authManager->assign($userAddRole, $user->id);//Сохраняем эту роль сотруднику
            return $user;//Возврашаем этого сотрудника
        }
        //если user не сохранился возврашаем ложь 
        return false;
    }
    /*
     * Метод редоктирует сотрудника
     */
    public function update(){
        //Проверяем есть ли сотрудник в БД
        if (($user = User::findOne($this->id)) !== null) {
            //если да
            $buferRole=0;//Переменная которая указывает нужно ли менять роль  сотрудника 0-нет 1-да
            $old_id_position=0;//переменная хранит id должности сотрудника до изменения 0 если измененй небыло
            //Изменяем поля у сотрудника в БД
            $user->id = $this->id;
            $user->email = $this->email;
            $user->employeename = $this->employeename;
            $user->phone = $this->phone;
            $user->address = $this->address;
            //Проверяем меняем ли мы пароль
            if(!empty($this->password)){
                //если да то генерируем хеш 
                $user->setPassword($this->password);  
            }
            //Проверяем меняеться ли должность
            if($user->id_position != $this->id_position){
                //Если да 
                $buferRole=1;//помешаем в буфер 1  меняем должность
                $old_id_position =  $user->id_position;//Сохраняем должность которая была назначенна ранее
                $user->id_position = $this->id_position;//Присваеваем новую должность        
            }    
            if ($user->save()){//Сохраняем изменения у сотрудника
                if($buferRole == 1){//Проверяем менялась ли должность
                     $arrayIdpositionRole = array(1=>'admin',2=>'manager',3=>'engineer');//Массив сопоставления id должности и роли
                    //Удаляем роль у сотрудника
                    $userDeleteRole = Yii::$app->authManager->getRole($arrayIdpositionRole[$old_id_position]);
                    Yii::$app->authManager->revoke($userDeleteRole, $user->id);
                    //Добовляем роль сотруднику
                    $userAddRole = Yii::$app->authManager->getRole($arrayIdpositionRole[$this->id_position]);
                    Yii::$app->authManager->assign($userAddRole, $user->id);
                }
                //возврашаем обьект user 
                return $user;
            }else{
                //Если не сохранились изменения в сотруднике возврашаем ложь 
                return FALSE;
            }
        } else {
            //Если не нашли сотрудника в БД возврашаем ложь
            return FALSE;  
        }
        
    }
    //Метод возврашает русские лейбы полей обьекта
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
