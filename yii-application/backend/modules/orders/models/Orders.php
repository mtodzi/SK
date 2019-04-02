<?php

namespace backend\modules\orders\models;

use Yii;
use backend\modules\orders\models\ClientsPhones;
use backend\modules\orders\models\OrdersClamedMalfunction;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "orders".
 *
 * @property int $id_orders
 * @property int $clients_id
 * @property int $serrial_nambers_id
 * @property int $repair_type
 * @property int $urgency
 * @property int $user_engener_id
 * @property int $user_manager_id
 * @property int $archive
 * @property string $appearance
 * @property string $special_notes
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Clients $clients
 * @property SerialNumbers $serrialNambers
 * @property User $userEngener
 * @property User $userManager
 * @property OrdersClamedMalfunction[] $ordersClamedMalfunctions
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clients_id', 'serrial_nambers_id', 'repair_type', 'urgency', 'user_engener_id', 'user_manager_id', 'archive'], 'integer'],
            [['repair_type', 'urgency', 'archive', 'appearance'], 'required'],
            [['special_notes'], 'string'],
            [['appearance'], 'string', 'max' => 255],
            [['clients_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['clients_id' => 'id_clients']],
            [['serrial_nambers_id'], 'exist', 'skipOnError' => true, 'targetClass' => SerialNumbers::className(), 'targetAttribute' => ['serrial_nambers_id' => 'id_serial_numbers']],
            [['user_engener_id'], 'exist', 'skipOnError' => true, 'targetClass' => '\common\models\User', 'targetAttribute' => ['user_engener_id' => 'id']],
            [['user_manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => '\common\models\User', 'targetAttribute' => ['user_manager_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_orders' => 'Id Orders',
            'clients_id' => 'Clients ID',
            'serrial_nambers_id' => 'Serrial Nambers ID',
            'repair_type' => 'Repair Type',
            'urgency' => 'Urgency',
            'user_engener_id' => 'User Engener ID',
            'user_manager_id' => 'User Manager ID',
            'archive' => 'Archive',
            'appearance' => 'Appearance',
            'special_notes' => 'Special Notes',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasOne(Clients::className(), ['id_clients' => 'clients_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSerrialNambers()
    {
        return $this->hasOne(SerialNumbers::className(), ['id_serial_numbers' => 'serrial_nambers_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEngener()
    {
        return $this->hasOne('\common\models\User', ['id' => 'user_engener_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserManager()
    {
        return $this->hasOne('\common\models\User', ['id' => 'user_manager_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersClamedMalfunctions()
    {
        return $this->hasMany(OrdersClamedMalfunction::className(), ['orders_id' => 'id_orders']);
    }
    
    //Метод формирует строку № заказа
    public function getOrderNumberText(){
        return "Заказ № ".$this->id_orders." от ".gmdate("d-m-Y", $this->created_at);;
    }
    //Метод возврашает первый телефон клиента
    public function getOnePhoneClient(){
        $ClientsPhones = ClientsPhones::findOne(['clients_id'=>$this->clients_id]);
        return $ClientsPhones->phone_number;
    }
    //Метод возврашает тип ремонта
    public function getRepairTypeString(){
        $repair_type = array(0=>"Ничего не делать",1=>"Диагностика",2=>"Ремонт",3=>"Диагностика и ремонт");
        return $repair_type[$this->repair_type];
    }
    
    //Метод возврашает описание девайса
    public function getDevicesText(){
        return $this->serrialNambers->devise->brands->name_brands." ".
               $this->serrialNambers->devise->devicesType->device_type_name." ".
               $this->serrialNambers->devise->devices_model." ". 
               "S/N:".$this->serrialNambers->serial_numbers_name;
    }
    
    //Метод возврашает заявленные неисправности
    public function getOrdersClamedMalfunction(){
        $OrdersClamedMalfunction = OrdersClamedMalfunction::findAll(['orders_id'=>$this->id_orders]);
        $text = "";
        foreach ($OrdersClamedMalfunction as $data){
            $text = $text.$data->claimedMalfunction->claimed_malfunction_name." ";
        }
        return $text;
    }
}
