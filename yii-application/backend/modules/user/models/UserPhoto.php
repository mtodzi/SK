<?php
namespace backend\modules\user\models;

use common\models\User;
use yii\base\Model;
use yii\helpers\BaseFileHelper;
use yii\helpers\Url;
use Yii;

class UserPhoto extends Model
{
    const SCENARIO_UPDATEPHOTO = 'updatephoto';//Сценарий обновить фото сатрудника
    const SCENARIO_FILEDELETEGENERAL = 'filedeletegeneral';//Сценарий удалить фото
    
    public $id;//id сатрудника которму добовляют или удаляют фото
    public $photo;//Файл с фото
    
    //Задаем какие поля будут проверяться в сценариях
    public function scenarios()
    {
        return [
            self::SCENARIO_UPDATEPHOTO => ['id','photo'],
            self::SCENARIO_FILEDELETEGENERAL => ['id'],            
        ];
    }
    //Задаем правила валидации для полей
    public function rules()
    {
        return [
            ['id', 'required'],
            [['id'], 'integer'],
            
            ['photo', 'file', 'extensions' => ['jpg','png']],
        ];
    }
    /*
        Метод загружает фото сотрудника
    */
    public function upload($token)
    {   //Задаем путь к нашей папке где будет храниться фото сатрудника
        $path = Yii::getAlias("@backend/web/img/users/".$this->id);
        $User = User::findOne($this->id);//находим в базе сотрудника которому добовляем или меняем фото
        if($User!==null){//Проверяем есть ли с базе такойсотрудник
            //если да то используем метод который загружает переданный файл 
            //он возврашает массив который необходимо вернуть пользователю
            return $this->uplodeFile($path,$User,$namefale,$token,0);
        }else{
            //Ели нет сотрудника проверяем может фото 
            //пришло из формы создания нового сотрудника
            if($this->id == 0){//если да 
                $id = Yii::$app->user->identity->id;//берем id сотрудника который послал фото 
                $User = User::findOne($id);//Находим этого сатрудника в БД
                $path = Yii::getAlias("@backend/web/img/users/newphoto/".$id);//Формируем другой путь где и временно сохраним файл
                return $this->uplodeFile($path,$User,$namefale,$token,1);//Сахроняем этот файл во временной директории
            }else{
                //Если сотрудника нет возврашаем сообшениие об ошибке 
                return ['reselt'=>0,'msg'=>'Сотрудник которому вы хотите добавить фото не найден в БД'];//Проверить!!
            }            
        }    
    }
    /*
       Метод загружает фото нового сотрудника из временной папки
    */
    public function uploadNewUser(){
        $id = Yii::$app->user->identity->id;
        $path = Yii::getAlias("@backend/web/img/users/".$this->id);
        $pathNewPhoto = Yii::getAlias("@backend/web/img/users/newphoto/".$id);
        if($this->isThereAPhoto($pathNewPhoto)){
            BaseFileHelper::createDirectory($path);
            $newFileName = $this->getNameFiles($pathNewPhoto);
            copy($pathNewPhoto.DIRECTORY_SEPARATOR.$newFileName, $path.DIRECTORY_SEPARATOR.$newFileName);
            $this->deleteFileInDirectories($pathNewPhoto);    
        }
        return TRUE;
    }

    public function delete($token)
    {
        if($this->id !=0){
            $path = Yii::getAlias("@backend/web/img/users/".$this->id);
            $User = User::findOne($this->id);
        }else{
            $id = Yii::$app->user->identity->id;
            $path = Yii::getAlias("@backend/web/img/users/newphoto/".$id);
            $User = User::findOne($id);
        }    
        if($User!==null){
            if(file_exists($path)){
                if($this->isThereAPhoto($path)){
                    if($this->deleteFileInDirectories($path)){ 
                        return ['reselt'=>1,'msg'=>array('append' => FALSE,)];
                    }else{
                        return ['reselt'=>0,'msg'=>'Не все заменяемые фото были удалены'];//Проверить!!
                    }
                }else{
                    return ['reselt'=>1,'msg'=>array('append' => FALSE,)];
                }
            }else{
                return ['reselt'=>1,'msg'=>array('append' => FALSE,)];                
            }
        }else{
            return ['reselt'=>0,'msg'=>'Сотрудник которому вы хотите удалить фото не найден в БД'];//Проверить!!
        }    
    }
    
    
    
    private function isThereAPhoto($path){
        $arrayImg = scandir($path);
        $arrayImg = array_diff($arrayImg, array('..', '.'));
        $cont = count($arrayImg);    
        if($cont == 0){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
    
    private function viewMinatureParameters(User $User,$namefale,$token,$newfile){
        $id = ($newfile == 0)?$User->id:0;
        $url = ($newfile == 0)?$User->getUrlMiniature():$this->getUrlMiniature($User->id);
        $items = [
            'initialPreview'=>"<img class='file-preview-image' id='modal_user_img_photo-".$id."' src='".$url."'  style=' width: 100px; height: 120px;'>",
            'initialPreviewConfig' => array(
                array('caption'=>$namefale,
                    'url'=>'/yii-application/backend/web/user/user/filedeletegeneral',
                        'key'=>100,
                        'extra'=>array(
                            'UserPhoto[id]'=>$id,
                            '_csrf-backend'=>$token
                        )
                    )
                ),
                'append' => FALSE,
        ];
        return $items;
    }
    
    private function getNameFiles($path){
        $arrayImg = scandir($path);
        $arrayImg = array_diff($arrayImg, array('..', '.'));
        $countPhoto = count($arrayImg);
        foreach ($arrayImg as $value){
            $img = $value;            
        }
        return $img;
    }
    
    private function deleteFileInDirectories($path){
        $arrayImg = scandir($path);
        $arrayImg = array_diff($arrayImg, array('..', '.'));
        $countPhoto = count($arrayImg);
        $i = 0;
        foreach ($arrayImg as $value){
            $img = $path.DIRECTORY_SEPARATOR.$value;
            if(unlink($img)){
                $i++;
            }            
        }
        if($countPhoto==$i){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    private function uplodeFile($path,User $User,$namefale,$token,$newfile){
        if(file_exists($path)){
            if($this->isThereAPhoto($path)){
                if($this->deleteFileInDirectories($path)){
                    $namefale = $this->photo->baseName . '.' . $this->photo->extension;
                    $this->photo->saveAs($path.DIRECTORY_SEPARATOR.$namefale);
                    $items = $this->viewMinatureParameters($User,$namefale,$token,$newfile);
                    return ['reselt'=>1,'msg'=>$items];
                }else{
                    return ['reselt'=>0,'msg'=>'Не все заменяемые фото были удалены'];//Проверить!!
                }
            }else{
                $namefale = $this->photo->baseName . '.' . $this->photo->extension;
                $this->photo->saveAs($path.DIRECTORY_SEPARATOR.$namefale);
                $items = $this->viewMinatureParameters($User,$namefale,$token,$newfile);
                return ['reselt'=>1,'msg'=>$items];
            }
        }else{
            BaseFileHelper::createDirectory($path);
            $namefale = $this->photo->baseName . '.' . $this->photo->extension;
            $this->photo->saveAs($path.DIRECTORY_SEPARATOR.$namefale);
            $items = $this->viewMinatureParameters($User,$namefale,$token,$newfile);
            return ['reselt'=>1,'msg'=>$items];
        }
    }
    
    private function getUrlMiniature($id){
            $pash = Yii::getAlias("@backend/web/img/users/newphoto/".$id);
            if(file_exists($pash)){
                $arrayImg = scandir($pash);
                $arrayImg = array_diff($arrayImg, array('..', '.'));
                $cont = count($arrayImg);    
                if($cont == 0){
                    $url = Url::to(['/img/users/default/default.svg']);
                    //$url = Yii::getAlias("@backend/web/fuser/user/defult/user.png");
                    return $url;   
                }else{
                    $url = Url::to(['/img/users/newphoto/'.$id.'/'.$arrayImg[2]]);                       
                    return $url;
                }
            }else{
                $url = Url::to(['/img/users/default/default.svg']);
                //$url = Yii::getAlias("@backend/web/fuser/user/defult/user.png");
                return $url;
            }    
        
    }
    
}


