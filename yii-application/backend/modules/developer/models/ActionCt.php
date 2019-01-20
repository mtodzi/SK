<?php

namespace backend\modules\developer\models;

use Yii;

/**
 * This is the model class for table "action_ct".
 *
 * @property integer $id
 * @property string $action_name
 * @property string $description
 * @property integer $id_controler
 *
 * @property Acsess[] $acsesses
 * @property Controler $idControler
 */
class ActionCt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'action_ct';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action_name', 'description'], 'required'],
            [['alias_action', 'description'], 'required'],
            [['description'], 'string'],
            [['id_controler'], 'integer'],
            [['action_name'], 'string', 'max' => 64],
            [['alias_action'], 'string', 'max' => 300],
            [['id_controler'], 'exist', 'skipOnError' => true, 'targetClass' => Controler::className(), 'targetAttribute' => ['id_controler' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Ключ'),
            'action_name' => Yii::t('app', 'Название действия'),
            'alias_action' => Yii::t('app', 'Псевдоним контроллера'),
            'description' => Yii::t('app', 'Описание действия'),
            'id_controler' => Yii::t('app', 'Ключ к контролеру этого действия'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcsesses()
    {
        return $this->hasMany(Acsess::className(), ['id_action_ct' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdControler()
    {
        return $this->hasOne(Controler::className(), ['id' => 'id_controler']);
    }

    /**
     * @inheritdoc
     * @return ActionCtQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActionCtQuery(get_called_class());
    }
}
