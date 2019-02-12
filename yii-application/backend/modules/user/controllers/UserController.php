<?php

namespace app\modules\user\controllers;

use Yii;
use common\models\User;
use backend\modules\user\models\UserEdit;
use backend\modules\user\models\UserSearch;
use backend\modules\user\models\UserPhoto;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\AcsessCo;
use backend\modules\user\models\UserArchive;
use yii\web\UploadedFile;



/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            
            'access' => [
                'class' => AccessControl::className(),
                'only' => AcsessCo::getAcsessAction('user'),
                'rules' => AcsessCo::getAcsess(Yii::$app->user->identity->id,'user')                
            ]
            
        ];
    }
    
    public function actions()
    {
    }

    /**
     * Метод выводить все карточки сотрудников из БД которые не в архиве
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Метод выводить все карточки сотрудников из БД которые в архиве
     */
    public function actionIndexarchive()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->searchArchive(Yii::$app->request->queryParams);

        return $this->render('archive', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Метод создает нового сотрудника в БД
     */
    public function actionCreate()
    {
        //Проверяе пришедший запрос AJAX
        if(\Yii::$app->request->isAjax){
            //Если создаем обьект UserEdit со сценарием SCENARIO_CREATE_NEW_USER
            $model = new UserEdit(['scenario' => UserEdit::SCENARIO_CREATE_NEW_USER]);
            //Проверяем загрузились ли данные в модель и проводим их валидацию
            if ($model->load(Yii::$app->request->post()) && $model->validate()){
                //Если дда то вызываем метод модели по созданию нового сотрудника в бд
                $model = $model->create_new_user();
                //Проверяем вернулся ли нам обьект
                if(!empty($model)){
                    $modelPhoto = new UserPhoto();
                    $modelPhoto->id = $model->id;
                    $modelPhoto->uploadNewUser();
                    //если модель сушествуем формируем карточку в HTML и передаем пользователю
                    return $this->renderAjax('create',['model'=>$model]);          
                }else{
                    //если у нас был false 
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['0','msg'=>"Пользователь не сохранен по неизвестной причине." ];
                    //Передаем данные в фармате json пользователю
                    return $items;
                }    
            }else{
                //Если данные на загрузились в обьект и не прошли валидацию
                //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                //Фармируем массив с ошибкой
                $items = ['0','msg'=>"Ошибка в заполненных полях", 'model'=>$model->getErrors()];
                //Передаем данные в фармате json пользователю
                return $items;
            }
        }else{
            //Если запрос был не AJAX делаем переадрисацю на главную страницу user
            return $this->redirect(['index']);  
        }
        
    }
    /*
        Метод добавляет в архив и удаляет из архива сотрудника
    */
    public function actionArchive(){
        //Проверяе пришедший запрос AJAX
        if(\Yii::$app->request->isAjax){
            $modelArhive = new UserArchive();
            //Проверяем загрузились ли данные в модель и проводим их валидацию
            if ($modelArhive->load(Yii::$app->request->post()) && $modelArhive->validate()){
                $buffer = $modelArhive->archive;
                if($modelArhive->archive()){
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    if($buffer == 0){
                        $items = ['1','msg'=>"сотрудник был добавлен в архив"];
                    }    
                    else{
                        $items = ['1','msg'=>"сотрудник был убран из архив"];
                    }
                    //Передаем данные в фармате json пользователю
                    return $items;
                }else{
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    if($buffer == 0){
                        $items = ['0','msg'=>"сотрудник не был добавлен в архив"];
                    }    
                    else{
                        $items = ['0','msg'=>"сотрудник не был удален из архива"];
                    }                   
                    //Передаем данные в фармате json пользователю
                    return $items;
                }
            }else{
                //Если данные на загрузились в обьект и не прошли валидацию
                //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                //Фармируем массив с ошибкой
                $items = ['0','msg'=>"Ошибка в отправленных полях на сервер", 'model'=>$modelArhive->getErrors()];
                //Передаем данные в фармате json пользователю
                return $items;
            }            
        }else{
            //Если запрос был не AJAX делаем переадрисацю на главную страницу user
            return $this->redirect(['index']); 
        }
    }
    
    /**
     * Метод редактирует Сотрудника в БД
     */
    public function actionUpdate(){
        //Проверяе пришедший запрос AJAX
        if(\Yii::$app->request->isAjax){
            //Проверяем была ли активирована смена пороля
            if(Yii::$app->request->post('check_user_pass_change')==0){
                //Если да то выбераем сценарий без ролверки полей пороля
                $model = new UserEdit(['scenario' => UserEdit::SCENARIO_NO_PASSWORD]);                
            }else{
                //Если нет то модели выбераем сценарий с проверкой поролей
                $model = new UserEdit(['scenario' => UserEdit::SCENARIO_PASSWORD]);    
            }
            //Загружаем данные в обьект и проводим и валидацию
            if ($model->load(Yii::$app->request->post()) && $model->validate()){
                //если проверка и загрузка проошла успешно обнавляем наш обьект и ложим туда обьект User
                //если изменения не применили возвратиться false
                $model = $model->update();
                //Проверяем вернулся ли нам обьект
                if(!empty($model)){
                    //Если да
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Формируем массив для передачи
                    $items = ['1','msg'=>"Модель загрузилась и сахранилась",
                        'model'=>[
                            'employeename'=>$model->employeename,
                            'email'=>$model->email,
                            'phone'=>$model->phone,
                            'address'=>$model->address,
                            'name_position'=>$model->position->name_position
                        ]
                    ];
                        //Передаем данные в фармате json пользователю
                        return $items;                     
                    }else{
                        //если у нас был false 
                        //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        //Фармируем массив с ошибкой
                        $items = ['0','msg'=>"Пользователь отсутствует в базе данных." ];
                        //Передаем данные в фармате json пользователю
                        return $items;
                    }
                }else{
                    //Если данные на загрузились в обьект и не прошли валидацию
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['0','msg'=>"Ошибка в заполненных полях", 'model'=>$model->getErrors()];
                    //Передаем данные в фармате json пользователю
                    return $items;
                }
        }else{
            //Если запрос был не AJAX делаем переадрисацю на главную страницу user
            return $this->redirect(['index']);
        }
    }
    
    public function actionUpdatephoto(){
        //Проверяе пришедший запрос AJAX
        if(\Yii::$app->request->isAjax){
            $modelPhoto = new UserPhoto(['scenario' => UserPhoto::SCENARIO_UPDATEPHOTO]);
            $modelPhoto->photo = UploadedFile::getInstance($modelPhoto, 'photo');
            $str = 'При загрузке файла возникли следующие ошибки: ';
            if ($modelPhoto->load(Yii::$app->request->post()) && $modelPhoto->validate()){
                $result = $modelPhoto->upload(Yii::$app->request->post('_csrf-backend'));
                if($result['reselt']!==0){
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем положительный ответ
                    $items = $result['msg'];
                    //Передаем данные в фармате json пользователю
                    return $items;
                }else{
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['error'=>$result['msg']];
                    //Передаем данные в фармате json пользователю
                    return $items;
                }
            }else{
                $errors = $modelPhoto->getErrors();
                foreach ($modelPhoto->getErrors() as $key => $value) {
                    foreach ($value as $data){
                        $str = $str." ".$data;
                    }
                }
                //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                //Фармируем массив с ошибкой
                $items = ['error'=>$str];
                //Передаем данные в фармате json пользователю
                return $items;
            }           
        }else{
            //Если запрос был не AJAX делаем переадрисацю на главную страницу user
            return $this->redirect(['index']);
        }
    }
    
    public function actionFiledeletegeneral(){
        if(\Yii::$app->request->isAjax){            
            $modelPhoto = new UserPhoto(['scenario' => UserPhoto::SCENARIO_FILEDELETEGENERAL]);
            $str = 'При удалении файла возникли следующие ошибки: ';//Проверить!!
            if ($modelPhoto->load(Yii::$app->request->post()) && $modelPhoto->validate()){
                $result = $modelPhoto->delete(Yii::$app->request->post('_csrf-backend'));
                if($result['reselt']!==0){
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем положительный ответ
                    $items = $result['msg'];
                    //Передаем данные в фармате json пользователю
                    return $items;
                }else{
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['error'=>$result['msg']];
                    //Передаем данные в фармате json пользователю
                    return $items;
                }
            }else{
                $errors = $modelPhoto->getErrors();
                foreach ($modelPhoto->getErrors() as $key => $value) {
                    foreach ($value as $data){
                        $str = $str." ".$data;
                    }
                }
                //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                //Фармируем массив с ошибкой
                $items = ['error'=>$str];
                //Передаем данные в фармате json пользователю
                return $items;
            }  
        }else{
            //Если запрос был не AJAX делаем переадрисацю на главную страницу user
            return $this->redirect(['index']);
        }  
    }
     
}
