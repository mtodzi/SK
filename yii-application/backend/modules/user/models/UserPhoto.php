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
        $path = Yii::getAlias("@backend/web/users/img/users/".$this->id);
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
                $path = Yii::getAlias("@backend/web/users/img/users/newphoto/".$id);//Формируем другой путь где и временно сохраним файл
                return $this->uplodeFile($path,$User,$namefale,$token,1);//Сахроняем этот файл во временной директории
            }else{
                //Если сотрудника нет возврашаем сообшениие об ошибке 
                return ['reselt'=>0,'msg'=>'Сотрудник которому вы хотите добавить фото не найден в БД'];//Проверить!!
            }            
        }    
    }
    /*
     * Метод загружает фото нового сотрудника из временной папки
     * сотрудника который добовляет нового пользователя 
    */
    public function uploadNewUser(){
        $id = Yii::$app->user->identity->id;//ложим в переменную id сотрудника который сделал запрос на сервер
        $path = Yii::getAlias("@backend/web/users/img/users/".$this->id);//Формруем путь в папку нового сотрудника где будем хранить его фото
        $pathNewPhoto = Yii::getAlias("@backend/web/users/img/users/newphoto/".$id);//Формируем путь в паку где храниться времеено загруженное фото сотрудника
        /*
         *Так как сотрудник может создаваться и без личного фото проверям
         * есть ли временный файл в папке создаюшего нового пользователя                    
         */
        if($this->isThereAPhoto($pathNewPhoto)){
            //если да 
            BaseFileHelper::createDirectory($path);//Создаем новую директорию для нового сотрудника под его id
            $newFileName = $this->getNameFiles($pathNewPhoto);//вызываем метод котрый вернет нам имя файла в временном хранилище
            copy($pathNewPhoto.DIRECTORY_SEPARATOR.$newFileName, $path.DIRECTORY_SEPARATOR.$newFileName);//Копируем этот файл из временной папки в папку сотрудника
            $this->deleteFileInDirectories($pathNewPhoto);//Удаляем временный файл    
        }
        return TRUE;
    }
    /*
     * Метод удаляет фото сотрудника из его папки $token - _csrf 
    */
    public function delete($token)
    {
        //Проверяем от кокого действие пришел запрос на удаления файла от формы создания или
        // от формы редактирования сотрудника
        if($this->id !=0){
            //Редактирование сотрудника
            $path = Yii::getAlias("@backend/web/users/img/users/".$this->id);//Формируем путь к папке где храняться фото сотрудника
            $User = User::findOne($this->id);//Находим сотрудника в БД
        }else{
            //Создание сотрудника
            $id = Yii::$app->user->identity->id;//узнаем id сотрудника который добавляет сотрудника
            $path = Yii::getAlias("@backend/web/users/img/users/".$id);//Формируем путь где храниться временный файл сртрудника
            $User = User::findOne($id);//Находим сотрудника в БД который добавляет нового сотрудника
        }
        //Проверяем нашли ли мы сотрудника в БД
        if($User!==null){
            //Если да
            //Проверяем сушествует ли деректория кв который необходимо удалить файл
            if(file_exists($path)){
                //если да проверяем есть ли фото в нашей директории испльзуя метод isThereAPhoto($path)
                if($this->isThereAPhoto($path)){
                    //Удаляем файл в директории и проверяем удалился ли он
                    if($this->deleteFileInDirectories($path)){
                        //Если да отправляем ответ об удачном удалении
                        return ['reselt'=>1,'msg'=>array('append' => FALSE,)];
                    }else{
                        //Если нет отправляем ответ с ошибкой
                        return ['reselt'=>0,'msg'=>'Не все заменяемые фото были удалены'];//Проверить!!
                    }
                }else{
                    //Если нет отправляем ответ об удачном удалении
                    return ['reselt'=>1,'msg'=>array('append' => FALSE,)];
                }
            }else{
                //Если нет отправляем ответ об удачном удалении
                return ['reselt'=>1,'msg'=>array('append' => FALSE,)];                
            }
        }else{
            //Если нет отправляем ответ с ошибкой
            return ['reselt'=>0,'msg'=>'Сотрудник которому вы хотите удалить фото не найден в БД'];//Проверить!!
        }    
    }
    
    /*
     * Метод проверяет есть ли фото в дриктории
     * $path - путь к этой директории 
    */    
    private function isThereAPhoto($path){
        $arrayImg = scandir($path);//Выбераем в массив все файлы в директории
        $arrayImg = array_diff($arrayImg, array('..', '.'));//очишаем массв от точки и двух точек
        $cont = count($arrayImg);//Подсчитываем количество элементов в массиве
        //Если в массиве 0 значит и файлов 0
        if($cont == 0){
            //Возврашаем ложь
            return FALSE;
        }else{
            //Возврашаем правду
            return TRUE;
        }
    }
    
    /*
     * Метод формирует ответ от сервера к клиенту при успешном сохранения файла не сервер
     * $User - обьект USER
     * $namefale - название файла
     * $token - _csrf
     * $newfile - указтель на то что файл загружается при редактировании сотрудника это 0 и 1 если сотрудника создают 
    */
    private function viewMinatureParameters(User $User,$namefale,$token,$newfile){
        //Создаем маасив с параметрами миниатюры файла который загрузили
        $id = ($newfile == 0)?$User->id:0;//Проверяем для редоктировани или создания сотрудника происходит формирование
        $url = ($newfile == 0)?$User->getUrlMiniature():$this->getUrlMiniature($User->id);//Проверяем для редоктировани или создания сотрудника происходит формирование
        //Формируем массив
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
        //Возврашаем массив
        return $items;
    }
    /*
     * Метод возврашает последнее имя файла в дериктории
     * $path - путь к этой директории 
    */
    private function getNameFiles($path){
        $img = NULL;
        $arrayImg = scandir($path);//Выбераем в массив все файлы в директории
        $arrayImg = array_diff($arrayImg, array('..', '.'));//очишаем массв от точки и двух точек
        $countPhoto = count($arrayImg);//Подсчитываем количество элементов в массиве
        //Перебераем все имена файлов в масиве
        foreach ($arrayImg as $value){
            $img = $value;            
        }
        //Возврашаем имя файла
        return $img;
    }
    /*
     * Метод удаляет все файлы в директории
     * $path - путь к этой директории 
    */
    private function deleteFileInDirectories($path){
        $arrayImg = scandir($path);//Выбераем в массив все файлы в директории
        $arrayImg = array_diff($arrayImg, array('..', '.'));//очишаем массв от точки и двух точек
        $countPhoto = count($arrayImg);//Подсчитываем количество элементов в массиве
        $i = 0;//Добавляем счетчик удаленных файлов
        foreach ($arrayImg as $value){//Пербераем все имена файлов
            $img = $path.DIRECTORY_SEPARATOR.$value;//формируем полный путь к файлу
            if(unlink($img)){//Удаляем файл и проверяем был ли он удален
                $i++;//если да увеличиваем счетчик
            }            
        }
        //Сравниваем счетчик удаленных файлов с количеством файлов в папке до удаленни
        if($countPhoto==$i){
            return TRUE;//если да то возврашаем правду
        }else{
            return FALSE;//если нет возврашаем ложь
        }
    }
    /*
     * Метод загружает файл на сервер 
     * $User - обьект USER
     * $namefale - название файла
     * $token - _csrf
     * $newfile - указтель на то что файл загружается при редактировании сотрудника это 0 и 1 если сотрудника создают
     *  
    */
    private function uplodeFile($path,User $User,$namefale,$token,$newfile){
        if(file_exists($path)){//Проверяем есть ли директория
            if($this->isThereAPhoto($path)){//если да то проверям есть ли там файл
                if($this->deleteFileInDirectories($path)){//если да то удаляем этот файл и проверяем удалился ли он
                    //если да
                    $namefale = $this->photo->baseName . '.' . $this->photo->extension;//Формируем имя файла
                    $this->photo->saveAs($path.DIRECTORY_SEPARATOR.$namefale);//Сохраняем файл
                    $items = $this->viewMinatureParameters($User,$namefale,$token,$newfile);//Формируем ответ пользователю
                    return ['reselt'=>1,'msg'=>$items];//возврашаем ответ об успешности
                }else{
                    //если нет возврашаем ответ с ошибкой
                    return ['reselt'=>0,'msg'=>'Не все заменяемые фото были удалены'];//Проверить!!
                }
            }else{
                //если нет файла в директории
                $namefale = $this->photo->baseName . '.' . $this->photo->extension;//Формируем имя файла
                $this->photo->saveAs($path.DIRECTORY_SEPARATOR.$namefale);//Сохраняем файл
                $items = $this->viewMinatureParameters($User,$namefale,$token,$newfile);//Формируем ответ пользователю
                return ['reselt'=>1,'msg'=>$items];//возврашаем ответ об успешности
            }
        }else{
            //Если нет директории с фото у сотрудника
            BaseFileHelper::createDirectory($path);//Создаем директорию
            $namefale = $this->photo->baseName . '.' . $this->photo->extension;//Формируем имя файла
            $this->photo->saveAs($path.DIRECTORY_SEPARATOR.$namefale);//Сохраняем файл
            $items = $this->viewMinatureParameters($User,$namefale,$token,$newfile);//Формируем ответ пользователю
            return ['reselt'=>1,'msg'=>$items];//возврашаем ответ об успешности
        }
    }
    
    /*
     * Метод возврашает путь к временному файлу при добавлении нового сотрудника 
     * $id - id сотрудника добавляюшего нового сотрудика
     *  
    */
    private function getUrlMiniature($id){
            $pash = Yii::getAlias("@backend/web/users/img/users/newphoto/".$id);//Путь в дерикторию с временным файлом
            if(file_exists($pash)){//Проверяем есть ли директория
                $arrayImg = scandir($pash);//если да то сканирум директорию на наличие файло
                $arrayImg = array_diff($arrayImg, array('..', '.'));//очишаем массв от точки и двух точек
                $cont = count($arrayImg);//Подсчитываем количество элементов в массиве  
                if($cont == 0){//Проверям их количество ли равно 0
                    //Формируем путь к файлу по умолчанию
                    $url = Url::to(['/users/img/users/default/default.svg']);
                    //$url = Yii::getAlias("@backend/web/fuser/user/defult/user.png");
                    return $url;//Возврашаем путь   
                }else{
                    //Если файл есть
                    //Формируем путь к временному файлу нового сотрудника 
                    $url = Url::to(['/users/img/users/newphoto/'.$id.'/'.$arrayImg[2]]);                       
                    return $url;//Возврашаем путь
                }
            }else{
                //Если нет директории
                //Формируем путь к файлу по умолчанию
                $url = Url::to(['/users/img/users/default/default.svg']);
                return $url;//Возврашаем путь
            }    
        
    }
    
}


