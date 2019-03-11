<?php

namespace backend\modules\orders\models;

use Yii;

/**
 * This is the model class for table "claimed_malfunction".
 *
 * @property int $id_claimed_malfunction
 * @property string $claimed_malfunction_name
 *
 * @property Orders[] $orders
 */
class ClaimedMalfunction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'claimed_malfunction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['claimed_malfunction_name'], 'required'],
            [['claimed_malfunction_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_claimed_malfunction' => 'Id Claimed Malfunction',
            'claimed_malfunction_name' => 'Claimed Malfunction Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['claimed_malfunction_id' => 'id_claimed_malfunction']);
    }
}
