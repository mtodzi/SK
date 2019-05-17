<?php

namespace backend\modules\stock\models;

use Yii;

/**
 * This is the model class for table "stocks".
 *
 * @property int $id_stocks
 * @property string $name_stock
 *
 * @property EquipmentStock[] $equipmentStocks
 */
class Stocks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stocks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_stock'], 'required'],
            [['name_stock'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_stocks' => 'Id Stocks',
            'name_stock' => 'Name Stock',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentStocks()
    {
        return $this->hasMany(EquipmentStock::className(), ['stock_id' => 'id_stocks']);
    }
}
