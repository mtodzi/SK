<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "position".
 *
 * @property int $id
 * @property string $name_position
 * @property string $description_position
 *
 * @property User[] $users
 */
class Position extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     * Задаем имя таблица в БД
     */
    public static function tableName()
    {
        return 'position';
    }

    /**
     * @inheritdoc
     * Задаем проверки полям
     */
    public function rules()
    {
        return [
            [['name_position'], 'required'],
            [['name_position', 'description_position'], 'string', 'max' => 255],
            [['name_position'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     * Задаем русски лейбы полям
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ключ должности',
            'name_position' => 'Название должности',
            'description_position' => 'Описание должности',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     * связуем таблицу User c Position по ключу 
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id_position' => 'id']);
    }
}
