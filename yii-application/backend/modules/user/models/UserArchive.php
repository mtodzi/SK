<?php
namespace backend\modules\user\models;

use common\models\User;
use yii\base\Model;
use Yii;


class UserArchive extends Model
{   
    //Поля передавемые при работе с добавлением и удалением из архива
    public $id;
    public $archive;

    //Назначаем проверки полям валидация
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
        //Находим сотрудника в БД
        $user = User::findOne($this->id);
        if($user!==null){//Проверяем Нашли ли мы его
            //если да
            if($this->archive == 0){//проверям помешаем ли мы работника в архив если 0 
                $user->archive = 1;//задаем полю 1
                $user->status  = 0;//задаем статус 0 чтобы пользователь не мог войти в систему под своими данными
                if ($user->save()) {//Проверяем сохранились ли изминения в БД
                    return TRUE;//Если да возврашаем правду
                }else{
                    return FALSE;//Если нет возврашаем ложь
                }
            }
            if($this->archive == 1){//проверям помешаем ли мы работника из архива если 1 
                $user->archive = 0;//задаем полю 0
                $user->status  = 10;//задаем статус 10 чтобы пользователь мог войти в систему под своими данными
                if ($user->save()) {//Проверяем сохранились ли изминения в БД
                    return TRUE;//Если да возврашаем правду
                }else{
                    return FALSE;//Если да возврашаем правду
                }
            }
            return FALSE;//если поле $this->archive не 0 и не 1 возврашаем ложь
        }else{
            return FALSE;//если сотрудника не нашли в БД возврашаем ложь
        }
    }    

}
