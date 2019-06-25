<?php

namespace backend\modules\stock\models;

use Yii;

/**
 * This is the model class for table "equipment_stock".
 *
 * @property int $stock_id
 * @property int $serial_number_id
 *
 * @property SerialNumbers $serialNumber
 * @property Stocks $stock
 */
class EquipmentStock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_stock';
    }

    public static function primaryKey()
    {
        return [
            'stock_id',
            'serial_number_id',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stock_id', 'serial_number_id'], 'required'],
            [['stock_id', 'serial_number_id'], 'integer'],
            [['serial_number_id'], 'exist', 'skipOnError' => true, 'targetClass' => SerialNumbers::className(), 'targetAttribute' => ['serial_number_id' => 'id_serial_numbers']],
            [['stock_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stocks::className(), 'targetAttribute' => ['stock_id' => 'id_stocks']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'stock_id' => 'Stock ID',
            'serial_number_id' => 'Serial Number ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSerialNumber()
    {
        return $this->hasOne(SerialNumbers::className(), ['id_serial_numbers' => 'serial_number_id']);
    }
    
    public function getDevices()
    {
        return $this->hasMany(Devices::className(), ['id_devices' => 'devise_id'])->via('serialNumber');
    }
    
    public function getBrands()
    {
        return $this->hasMany(Brands::className(), ['id_brands' => 'brands_id'])->via('devices');
    }
    
    public function getDevicesType()
    {
        return $this->hasMany(DeviceType::className(), ['id_device_type' => 'devices_type_id'])->via('devices');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStock()
    {
        return $this->hasOne(Stocks::className(), ['id_stocks' => 'stock_id']);
    }
}
