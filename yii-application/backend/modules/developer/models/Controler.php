<?php

namespace backend\modules\developer\models;

use Yii;

/**
 * This is the model class for table "controler".
 *
 * @property integer $id
 * @property string $name_controler
 *
 * @property Acsess[] $acsesses
 */
class Controler extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'controler';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_controler'], 'required'],
            [['alias_controler'], 'required'],
            [['description'], 'required'],
            [['name_controler'], 'string', 'max' => 64],
            [['alias_controler'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Ключ'),
            'name_controler' => Yii::t('app', 'Имя контролера'),
            'description' => Yii::t('app', 'Описание'),
            'alias_controler' => Yii::t('app', 'Псевдоним контроллера'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcsesses()
    {
        return $this->hasMany(Acsess::className(), ['id_controler' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ControlerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ControlerQuery(get_called_class());
    }
}
