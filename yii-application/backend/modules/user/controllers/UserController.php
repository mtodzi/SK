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
     * Lists all User models.
     * @return mixed
     * 'view','create','update','delete','changepassword',
                            'createrole','asktheemployeerole','deletingauserrole'
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
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();
        //$modelUser = new User;

        if ($model->load(Yii::$app->request->post())) {
            $modelUser = $model->signup();
            if($modelUser !== null){
                return $this->render('foto',['model'=>$modelUser]); 
            }else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            
            //return $this->redirect(['view', 'id' => $modelUser->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        //Проверяе пришедший запрос AJAX
        if(\Yii::$app->request->isAjax){
            if(Yii::$app->request->post('check_user_pass_change')==0){
                $model = new UserEdit(['scenario' => UserEdit::SCENARIO_NO_PASSWORD]);                
            }else{
                $model = new UserEdit(['scenario' => UserEdit::SCENARIO_PASSWORD]);    
            }
            if ($model->load(Yii::$app->request->post()) && $model->validate()){
                    $model = $model->update();
                    if(!empty($model)){
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
                        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;                
                        $items = ['0','msg'=>"Пользователь отсутствует в базе данных." ];
                        return $items;
                    }
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;                
                    $items = ['0','msg'=>"Не пароль", 'modeltest'=>$model];
                    return $items;
                }else{
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;                
                    $items = ['0','msg'=>"Модель не загрузилась и не сахранилась", 'model'=>$model->getErrors()];
                    return $items;
                }
            
            /*
            $buferRole=0;//Переменная которая указывает нужно ли менять роль  сотрудника 0-нет 1-да
            $old_id_position=0;//переменная хранит id должности сотрудника до изменения 0 если измененй небыло
            $model = $this->findModelAJAX(Yii::$app->request->post('User')['id']);//вытаскиваем из базы данные сотрудника
            if(!empty($model)){//Проверяем сушествует ли эти данные в БД
                $id_position = Yii::$app->request->post('User')['id_position'];//Помешаем в переменную id должности преслонную от пользователя
                if($id_position != $model->id_position){//Сравнивваем присланный id c тем который в БД если разные
                    $old_id_position = $model->id_position;//помешаем в переменную тот каторый в БД
                    $model->id_position = $id_position;//Изменяем занчение id должности в модели из БД на то что прислали
                    $buferRole++;//увеличаваем на 1 с 0 тем самым закладываем изменение роли у сотрудника из ходя от его должности
                }
                //загружаем в модель с данными из БД данные пришедшие от пользователя и сохраняем их в бд и если все ок
                if ($model->load(Yii::$app->request->post()) && $model->save()){
                    if($buferRole == 1){//проверяем изменялась ли у нас должность 
                        $arrayIdpositionRole = array(1=>'admin',2=>'manager',3=>'engineer');//Массив сопоставления id должности и роли
                        //Удаляем роль у сотрудника
                        $userDeleteRole = Yii::$app->authManager->getRole($arrayIdpositionRole[$old_id_position]);
                        Yii::$app->authManager->revoke($userDeleteRole, $model->id);
                        //Добовляем роль сотруднику
                        $userAddRole = Yii::$app->authManager->getRole($arrayIdpositionRole[$model->id_position]);
                        Yii::$app->authManager->assign($userAddRole, $model->id);
                    }
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
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;                
                    $items = ['0','msg'=>"Модель не загрузилась и не сахранилась", 'model'=>$model->getErrors()];
                    return $items;
                }                     
            }else{
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;            
                $items = [0,'msg'=>"Данные не обнаружены на сервере. Попробуйте заново."];
                return $items;
            }
             * 
             */
        }else{
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

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionChangepassword($id){
        $modelUser = new Changepassword();
        $model= $this->findModel($id);
        if($modelUser->load(Yii::$app->request->post())){
           $model = $modelUser->signup();
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('changepassword', [
            'model' => $model, 'modelUser'=>$modelUser   
            ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    public function actionCreaterole(){
        $role = new AddRole();
        
        if($role->load(Yii::$app->request->post()) && $role->validate()){
            
            $role->roleSave();
            Yii::$app->session->setFlash('success', 'Роль была добавлена');
            return $this->refresh();
              
        }
        
        return $this->render('addFormRole',['role'=>$role]);
    }
    
    public function actionCreatepermission(){
        $permission = new AddPermission();
        
        if($permission->load(Yii::$app->request->post()) && $permission->validate()){
            
            $permission->permissionSave();
            Yii::$app->session->setFlash('success', 'Разрешение была добавлена');
            return $this->refresh();
              
        }
        
        return $this->render('addFormPermission',['permission'=>$permission]);
    }
    
    public function actionAsktheemployeerole($id){
        $modelUser = $this->findModel($id);
        $model = new AsktheEmployeeRole();
        if($model->load(Yii::$app->request->post())){
            $modelUser = $model->employeeRole();
            //$modelUser = $this->findModel($id);
            return $this->redirect(['view', 'id' => $modelUser->id]);
        }
        return $this->render('asktheemployeerole',
                                ['modelUser'=>$modelUser, 'model'=>$model]);
    }
    public function  actionDeletingauserrole($id){
        $modelUser = $this->findModel($id);
        $model = new AsktheEmployeeRole();
        if($model->load(Yii::$app->request->post())){
            $modelUser = $model->deleteRole();
            //$modelUser = $this->findModel($id);
            return $this->redirect(['view', 'id' => $modelUser->id]);
        }
        return $this->render('deletingauserrole',
                                ['modelUser'=>$modelUser, 'model'=>$model]);   
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
