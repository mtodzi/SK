<?php

namespace backend\modules\orders\models;

use Yii;

/**
 * This is the model class for table "changes_tables".
 *
 * @property string $table_name
 * @property int $id_change_item
 * @property string $description_changes
 * @property int $user_change_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $userChange
 */
class ChangesTables extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'changes_tables';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['table_name', 'created_at', 'updated_at'], 'required'],
            [['id_change_item', 'user_change_id', 'created_at', 'updated_at'], 'integer'],
            [['description_changes'], 'string'],
            [['table_name'], 'string', 'max' => 255],
            [['user_change_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_change_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'table_name' => 'Table Name',
            'id_change_item' => 'Id Change Item',
            'description_changes' => 'Description Changes',
            'user_change_id' => 'User Change ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserChange()
    {
        return $this->hasOne(User::className(), ['id' => 'user_change_id']);
    }
}
