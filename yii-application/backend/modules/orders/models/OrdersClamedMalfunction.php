<?php

namespace backend\modules\orders\models;

use Yii;

/**
 * This is the model class for table "orders_clamed_malfunction".
 *
 * @property int $orders_id
 * @property int $claimed_malfunction_id
 *
 * @property ClaimedMalfunction $claimedMalfunction
 * @property Orders $orders
 */
class OrdersClamedMalfunction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders_clamed_malfunction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['orders_id', 'claimed_malfunction_id'], 'required'],
            [['orders_id', 'claimed_malfunction_id'], 'integer'],
            [['claimed_malfunction_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClaimedMalfunction::className(), 'targetAttribute' => ['claimed_malfunction_id' => 'id_claimed_malfunction']],
            [['orders_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['orders_id' => 'id_orders']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'orders_id' => 'Orders ID',
            'claimed_malfunction_id' => 'Claimed Malfunction ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClaimedMalfunction()
    {
        return $this->hasOne(ClaimedMalfunction::className(), ['id_claimed_malfunction' => 'claimed_malfunction_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasOne(Orders::className(), ['id_orders' => 'orders_id']);
    }
}
