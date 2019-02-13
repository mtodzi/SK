<?php

namespace backend\modules\orders\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property int $id_clients
 * @property string $clients_name
 * @property string $clients_email
 * @property string $clients_address
 * @property int $clients_archive
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ClientsPhones[] $clientsPhones
 * @property Orders[] $orders
 */
class Clients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clients_name', 'created_at', 'updated_at'], 'required'],
            [['clients_archive', 'created_at', 'updated_at'], 'integer'],
            [['clients_name'], 'string', 'max' => 50],
            [['clients_email'], 'string', 'max' => 100],
            [['clients_address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_clients' => 'Id Clients',
            'clients_name' => 'Clients Name',
            'clients_email' => 'Clients Email',
            'clients_address' => 'Clients Address',
            'clients_archive' => 'Clients Archive',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientsPhones()
    {
        return $this->hasMany(ClientsPhones::className(), ['clients_id' => 'id_clients']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['clients_id' => 'id_clients']);
    }
}
