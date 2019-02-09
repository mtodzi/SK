<?php
namespace backend\modules\user\models;

use common\models\User;
use yii\base\Model;
use yii\helpers\BaseFileHelper;
use Yii;

class UserPhoto extends Model
{
    const SCENARIO_UPDATEPHOTO = 'updatephoto';
    const SCENARIO_FILEDELETEGENERAL = 'filedeletegeneral';
    
    public $id;
    public $photo;
    
    public function scenarios()
    {
        return [
            self::SCENARIO_UPDATEPHOTO => ['id','photo'],
            self::SCENARIO_FILEDELETEGENERAL => ['id'],            
        ];
    }
    
    public function rules()
    {
        return [
            ['id', 'required'],
            [['id'], 'integer'],
            
            ['photo', 'file', 'extensions' => ['jpg','png']],
        ];
    }
    
    public function upload($token)
    {
        $path = Yii::getAlias("@backend/web/img/users/".$this->id);
        $User = User::findOne($this->id);
        if($User!==null){
            if(file_exists($path)){
                if($this->isThereAPhoto($path)){
                    if($this->deleteFileInDirectories($path)){
                        $namefale = $this->photo->baseName . '.' . $this->photo->extension;
                        $this->photo->saveAs($path.DIRECTORY_SEPARATOR.$namefale);
                        $items = $this->viewMinatureParameters($User,$namefale,$token);
                        return ['reselt'=>1,'msg'=>$items];
                    }else{
                        return ['reselt'=>0,'msg'=>'Не все заменяемые фото были удалены'];//Проверить!!
                    }
                }else{
                    $namefale = $this->photo->baseName . '.' . $this->photo->extension;
                    $this->photo->saveAs($path.DIRECTORY_SEPARATOR.$namefale);
                    $items = $this->viewMinatureParameters($User,$namefale,$token);
                    return ['reselt'=>1,'msg'=>$items];
                }
            }else{
                BaseFileHelper::createDirectory($path);
                $namefale = $this->photo->baseName . '.' . $this->photo->extension;
                $this->photo->saveAs($path.DIRECTORY_SEPARATOR.$namefale);
                $items = $this->viewMinatureParameters($User,$namefale,$token);
                return ['reselt'=>1,'msg'=>$items];
            }
        }else{
            return ['reselt'=>0,'msg'=>'Сотрудник которому вы хотите добавить фото не найден в БД'];//Проверить!!
        }    
    }
    
    public function delete($token)
    {
        $path = Yii::getAlias("@backend/web/img/users/".$this->id);
        $User = User::findOne($this->id);
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
    
    
    private function viewMinatureParameters(User $User, $namefale,$token){
        $items = [
            'initialPreview'=>"<img class='file-preview-image' id='modal_user_img_photo-".$User->id."' src='".$User->getUrlMiniature()."'  style=' width: 100px; height: 120px;'>",
            'initialPreviewConfig' => array(
                array('caption'=>$namefale,
                    'url'=>'/yii-application/backend/web/user/user/updatephoto',
                        'key'=>100,
                        'extra'=>array(
                            'id'=>$User->id,
                            '_csrf-backend'=>$token
                        )
                    )
                ),
                'append' => FALSE,
        ];
        return $items;
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
    
}


