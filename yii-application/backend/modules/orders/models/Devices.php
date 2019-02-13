<?php

namespace backend\modules\orders\models;

use Yii;

/**
 * This is the model class for table "devices".
 *
 * @property int $id_devices
 * @property int $brands_id
 * @property int $devices_type_id
 * @property string $devices_model
 *
 * @property Brands $brands
 * @property DeviceType $devicesType
 * @property SerialNumbers[] $serialNumbers
 */
class Devices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'devices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brands_id', 'devices_type_id'], 'integer'],
            [['devices_model'], 'required'],
            [['devices_model'], 'string', 'max' => 255],
            [['brands_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brands::className(), 'targetAttribute' => ['brands_id' => 'id_brands']],
            [['devices_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => DeviceType::className(), 'targetAttribute' => ['devices_type_id' => 'id_device_type']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_devices' => 'Id Devices',
            'brands_id' => 'Brands ID',
            'devices_type_id' => 'Devices Type ID',
            'devices_model' => 'Devices Model',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrands()
    {
        return $this->hasOne(Brands::className(), ['id_brands' => 'brands_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevicesType()
    {
        return $this->hasOne(DeviceType::className(), ['id_device_type' => 'devices_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSerialNumbers()
    {
        return $this->hasMany(SerialNumbers::className(), ['devise_id' => 'id_devices']);
    }
}
