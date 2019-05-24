<?php

namespace backend\modules\stock\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['table_name'], 'required'],
            [['id_change_item', 'user_change_id'], 'integer'],
            [['description_changes'], 'string'],
            [['table_name'], 'string', 'max' => 255],
            [['user_change_id'], 'exist', 'skipOnError' => true, 'targetClass' => '\common\models\User', 'targetAttribute' => ['user_change_id' => 'id']],
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
    
    function __construct($table_name, $id_change_item, $description_changes, $user_change_id){
        $this->table_name = $table_name;
        $this->id_change_item = $id_change_item;
        $this->description_changes = $description_changes;
        $this->user_change_id = $user_change_id;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserChange()
    {
        return $this->hasOne(User::className(), ['id' => 'user_change_id']);
    }
}
