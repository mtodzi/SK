<?php

namespace backend\modules\orders\models;

use Yii;

/**
 * This is the model class for table "serial_numbers".
 *
 * @property int $id_serial_numbers
 * @property string $serial_numbers_name
 * @property int $devise_id
 *
 * @property Orders[] $orders
 * @property Devices $devise
 */
class SerialNumbers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'serial_numbers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['serial_numbers_name'], 'required'],
            [['devise_id'], 'integer'],
            [['serial_numbers_name'], 'string', 'max' => 255],
            [['devise_id'], 'exist', 'skipOnError' => true, 'targetClass' => Devices::className(), 'targetAttribute' => ['devise_id' => 'id_devices']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_serial_numbers' => 'Id Serial Numbers',
            'serial_numbers_name' => 'Serial Numbers Name',
            'devise_id' => 'Devise ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['serrial_nambers_id' => 'id_serial_numbers']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevise()
    {
        return $this->hasOne(Devices::className(), ['id_devices' => 'devise_id']);
    }
}
