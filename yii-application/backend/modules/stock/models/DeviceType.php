<?php

namespace backend\modules\stock\models;

use Yii;

/**
 * This is the model class for table "device_type".
 *
 * @property int $id_device_type
 * @property string $device_type_name
 *
 * @property Devices[] $devices
 */
class DeviceType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'device_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['device_type_name'], 'required'],
            [['device_type_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_device_type' => 'Id Device Type',
            'device_type_name' => 'Device Type Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevices()
    {
        return $this->hasMany(Devices::className(), ['devices_type_id' => 'id_device_type']);
    }
}
