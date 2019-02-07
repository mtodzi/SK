<?php
namespace backend\modules\user\models;

use common\models\User;
use yii\base\Model;
use Yii;


class UserArchive extends Model
{       
    public $id;
    public $archive;


    public function rules()
    {
        return [
            ['id', 'required'],
            [['id'], 'integer'],
            
            ['archive', 'required'],
            [['archive'], 'integer'],
        ];
    }
    /*
     * Метод редоктирует сотрудника
     */
    public function archive(){
        $user = User::findOne($this->id);
        if($user!==null){
            if($this->archive == 0){
                $user->archive = 1;
                $user->status  = 0;
                if ($user->save()) {
                    return TRUE;
                }else{
                    return FALSE;
                }
            }
            if($this->archive == 1){
                $user->archive = 0;
                $user->status  = 10;
                if ($user->save()) {
                    return TRUE;
                }else{
                    return FALSE;
                }
            }
            return FALSE;
        }else{
            return FALSE;
        }
    }    

}
