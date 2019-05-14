<?php

namespace backend\modules\clients\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\clients\models\ClientsSearch;
use backend\modules\clients\models\ClientsEdit;
use backend\modules\clients\models\ClientsPhonesEdit;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\AcsessCo;

/**
 * Default controller for the `clients` module
 */
class ClientController extends Controller
{
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
                'only' => AcsessCo::getAcsessAction('client'),
                'rules' => AcsessCo::getAcsess(Yii::$app->user->identity->id,'client')                
            ]
            
        ];
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ClientsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate(){
        if(\Yii::$app->request->isAjax){
            $countError = 0;
            $errorsClientsEdit = 0;
            $errorsClientsPhonesEdit = 0;
            
            $modelClientsPhonesEdit = new ClientsPhonesEdit();
            $modelClientsEdit = new ClientsEdit();
            
            if($modelClientsEdit->load(Yii::$app->request->post()) && !$modelClientsEdit->validate()){
                $countError++;
                $errorsClientsEdit = $modelClientsEdit->getErrors();
            }
            if($modelClientsPhonesEdit->load(Yii::$app->request->post()) && !$modelClientsPhonesEdit->validate()){
                $countError++;
                $errorsClientsPhonesEdit = $modelClientsPhonesEdit->getErrors();
            }
            
            if($countError==0){
                $countErrorSave = 0;
                $msgCountErrorSave = 'Ошибки сохранения - ';
                $modelClientsEdit = $modelClientsEdit->saveClients();
                if($modelClientsEdit!==null){
                    $modelClientsPhonesEdit->savePhoneClients($modelClientsEdit->id_clients);
                }else{
                    $countErrorSave++;
                    $msgCountErrorSave = $msgCountErrorSave." клиент не был сохранен, ";
                }
                if($countErrorSave == 0){
                    $select = $this->renderAjax('clientscard', ['model' => $modelClientsEdit,]);
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['200','msg'=>'Успешная работа!', 'txt'=>$select, 'id'=>$modelClientsEdit->id_clients];
                    //Передаем данные в фармате json пользователю
                    return $items;
                }else{
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['200','msg'=>$msgCountErrorSave, 'txt'=>0];
                    return $items;
                }
            }else{
                //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                //Фармируем массив с ошибкой
                $items = ['0',
                    'msg'=>'Передаваемые данные не прошли проверку',                    
                    'errorsClientsEdit'=>$errorsClientsEdit,
                    'errorsClientsPhonesEdit'=>$errorsClientsPhonesEdit,   
                ];
                //Передаем данные в фармате json пользователю
                return $items;
            }
        }else{
            //Если запрос был не AJAX делаем переадрисацю на главную страницу user
            return $this->redirect(['index']);
        }
    }
    
    public function actionUpdate(){
        if(\Yii::$app->request->isAjax){
            $countError = 0;
            $errorsClientsEdit = 0;
            $errorsClientsPhonesEdit = 0;
            
            $modelClientsPhonesEdit = new ClientsPhonesEdit();
            $modelClientsEdit = new ClientsEdit();
            
            if($modelClientsEdit->load(Yii::$app->request->post()) && !$modelClientsEdit->validate()){
                $countError++;
                $errorsClientsEdit = $modelClientsEdit->getErrors();
            }
            if($modelClientsPhonesEdit->load(Yii::$app->request->post()) && !$modelClientsPhonesEdit->validate()){
                $countError++;
                $errorsClientsPhonesEdit = $modelClientsPhonesEdit->getErrors();
            }
            
            if($countError==0){
                $countErrorSave = 0;
                $msgCountErrorSave = 'Ошибки сохранения - ';
                $modelClientsEdit = $modelClientsEdit->saveClients();
                if($modelClientsEdit!==null){
                    $modelClientsPhonesEdit->savePhoneClients($modelClientsEdit->id_clients);
                }else{
                    $countErrorSave++;
                    $msgCountErrorSave = $msgCountErrorSave." клиент не был сохранен, ";
                }
                if($countErrorSave == 0){
                    $select = $this->renderAjax('clientscard', ['model' => $modelClientsEdit,]);
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['200','msg'=>'Успешная работа!', 'txt'=>$select, 'id'=>$modelClientsEdit->id_clients];
                    //Передаем данные в фармате json пользователю
                    return $items;
                }else{
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['200','msg'=>$msgCountErrorSave, 'txt'=>0];
                    return $items;
                }
            }else{
                //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                //Фармируем массив с ошибкой
                $items = ['0',
                    'msg'=>'Передаваемые данные не прошли проверку',                    
                    'errorsClientsEdit'=>$errorsClientsEdit,
                    'errorsClientsPhonesEdit'=>$errorsClientsPhonesEdit,   
                ];
                //Передаем данные в фармате json пользователю
                return $items;
            }
        }else{
            //Если запрос был не AJAX делаем переадрисацю на главную страницу user
            return $this->redirect(['index']);
        }
    }
}
