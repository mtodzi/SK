<?php

namespace backend\modules\acsess\models;

use Yii;
use backend\modules\developer\models\ActionCt;
/**
 * This is the model class for table "acsess".
 *
 * @property integer $id
 * @property string $item_name
 * @property integer $id_action_ct
 * @property integer $rows
 *
 * @property AuthItem $itemName
 * @property ActionCt $idActionCt
 */
class Acsess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'acsess';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_name', 'id_action_ct', 'rows'], 'required'],
            [['id_action_ct', 'rows'], 'integer'],
            [['item_name'], 'string', 'max' => 64],
            [['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['item_name' => 'name']],
            [['id_action_ct'], 'exist', 'skipOnError' => true, 'targetClass' => ActionCt::className(), 'targetAttribute' => ['id_action_ct' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'item_name' => Yii::t('app', 'Роль'),
            'id_action_ct' => Yii::t('app', 'Id Action Ct'),
            'rows' => Yii::t('app', 'Доступ'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemName()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdActionCt()
    {
        return $this->hasOne(ActionCt::className(), ['id' => 'id_action_ct']);
    }
    public function getRowsLabel()
    {
       if($this->rows == 0){
            return 'Запрещено';
       }else{
            return 'Разрешено';
       }
    }

    /**
     * @inheritdoc
     * @return AcsessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AcsessQuery(get_called_class());
    }
}
