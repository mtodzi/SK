<?php

namespace backend\modules\clients\models;

use Yii;

/**
 * This is the model class for table "clients_phones".
 *
 * @property int $clients_id
 * @property string $phone_number
 *
 * @property Clients $clients
 */
class ClientsPhones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients_phones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clients_id', 'phone_number'], 'required'],
            [['clients_id'], 'integer'],
            [['phone_number'], 'string', 'max' => 16],
            [['clients_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['clients_id' => 'id_clients']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'clients_id' => 'Clients ID',
            'phone_number' => 'Phone Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasOne(Clients::className(), ['id_clients' => 'clients_id']);
    }
}
