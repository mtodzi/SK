<?php

namespace backend\modules\user\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\User;

/**
 * This is the model class for table "posts".
 *
 * @property int $id_user_to_whom
 * @property int $id_user_from_whom
 * @property string $body_post
 * @property int $created_at
 * @property int $read_mark
 *
 * @property User $userToWhom
 * @property User $userFromWhom
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }
    
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user_to_whom', 'id_user_from_whom', 'body_post', 'read_mark'], 'required'],
            [['id_user_to_whom', 'id_user_from_whom', 'read_mark'], 'integer'],
            [['body_post'], 'string'],
            [['id_user_to_whom'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user_to_whom' => 'id']],
            [['id_user_from_whom'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user_from_whom' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_user_to_whom' => 'Кому',
            'id_user_from_whom' => 'От кого',
            'body_post' => 'Тело собшения',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата Изменения',
            'read_mark' => 'Метка чтения',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserToWhom()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user_to_whom']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFromWhom()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user_from_whom']);
    }
    public  function getCountNewPostsUser($id){
        return $this->find()->where(['id_user_to_whom'=>$id, 'read_mark'=>0])->count();
    }
}
