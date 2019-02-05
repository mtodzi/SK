<?php

namespace app\modules\user\controllers;

use Yii;
use common\models\User;
use backend\modules\user\models\SignupForm;
use backend\modules\user\models\UserEdit;
use backend\modules\user\models\Changepassword;
use backend\modules\user\models\AsktheEmployeeRole;
use backend\models\AddRole;
use backend\modules\user\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\AddPermission;
use common\models\AcsessCo;



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
        return [
            'uploadPhoto' => [
                'class' => 'budyaga\cropper\actions\UploadAction',
                'url' => '/advanced/backend/web/fuser/user',
                'path' => '@backend/web/fuser/user',
            ]
        ];
    }

    /**
     * Метод выводить все карточки сотрудников из БД
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
    
    protected function findModelAJAX($id)
    {   
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            return FALSE;  
        }
    }

    public function actionFoto($id){
        $model = $this->findModel($id);
        return $this->render('foto',['model'=>$model]);
    }
    
    public function actionFiledeletegeneral(){
        if(Yii::$app->request->isPost){            
            $id = Yii::$app->request->post("id");
            $pash = Yii::getAlias("@backend/web/fuser/user/".$id);
            if(file_exists($pash)){
                $arrayImg = scandir($pash);
                $arrayImg = array_diff($arrayImg, array('..', '.'));
                $cont = count($arrayImg);    
                if($cont == 0){
                  return $this->redirect(['view','id'=>$id]);
                }else{
                    foreach ($arrayImg as $value){
                        $img = $pash.DIRECTORY_SEPARATOR.$value;
                        unlink($img);
                    }
                    return $this->redirect(['view','id'=>$id]);
                }
               
           }else{                
                return $this->redirect(['view','id'=>$id]);
           } 
        }
        
    }
    
    public function actionMytest(){
        return $this->render('test'); 
    }
    
}
