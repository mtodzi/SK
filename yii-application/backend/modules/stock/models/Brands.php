<?php

namespace backend\modules\stock\models;

use Yii;

/**
 * This is the model class for table "brands".
 *
 * @property int $id_brands
 * @property string $name_brands
 *
 * @property Devices[] $devices
 */
class Brands extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brands';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_brands'], 'required'],
            [['name_brands'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_brands' => 'Id Brands',
            'name_brands' => 'Name Brands',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevices()
    {
        return $this->hasMany(Devices::className(), ['brands_id' => 'id_brands']);
    }
}
