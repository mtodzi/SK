<?php

namespace backend\modules\orders\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\orders\models\OrdersSearch;
use backend\modules\orders\models\SearchInputOrders;
use backend\modules\orders\models\SearchClientsSubstitution;
/**
 * Default controller for the `orders` module
 */
class DefaultController extends Controller
{
    /**
     * Выводит все заказы которые не в архиве
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /*
     *Метод возврашает Список Имен клиентов при наборе в поле     
     * 
     */
    public function actionTakenameclient(){
        if(\Yii::$app->request->isAjax){
            $modelSearchInputOrders =  new SearchInputOrders(['scenario' => SearchInputOrders::SCENARIO_CLIENTS_NAME]);
            if($modelSearchInputOrders->load(Yii::$app->request->post()) && $modelSearchInputOrders->validate()){
                $id_orders = $modelSearchInputOrders->id_orders;
                $model_clients = $modelSearchInputOrders->SearchClientsName();
                if($model_clients){
                    $select = $this->renderAjax('select', ['model_clients'=>$model_clients,'id_orders'=>$id_orders]);
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['200','msg'=>$select,'id_orders'=>$id_orders];
                    //Передаем данные в фармате json пользователю
                    return $items;
                }else{
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['0','msg'=>'В БД ничего не было найдено'];
                    //Передаем данные в фармате json пользователю
                    return $items;
                }    
            }else{
                //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                //Фармируем массив с ошибкой
                $items = ['0','msg'=>'Передаваемые данные не прошли проверку'];
                //Передаем данные в фармате json пользователю
                return $items;
            }
            
           
        }else{
            //Если запрос был не AJAX делаем переадрисацю на главную страницу user
            return $this->redirect(['index']);
        }    
    }
    
    /*
     *Метод возврашает выбранного клиента из списка пользователя 
     * 
     */
    public function actionTakeclient(){
        if(\Yii::$app->request->isAjax){
            $SearchClientsSubstitution =  new SearchClientsSubstitution();
            if($SearchClientsSubstitution->load(Yii::$app->request->post()) && $SearchClientsSubstitution->validate()){
                $modelOrders = $SearchClientsSubstitution->SearchOrders();
                $modelClients = $SearchClientsSubstitution->SearchClients();
                if(($modelOrders || $SearchClientsSubstitution->id_orders==0) && $modelClients){
                    $viewclientform = $this->renderAjax('viewclientform', ['modelOrders'=>$modelOrders,'modelClients'=>$modelClients]);
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['200','msg'=>$viewclientform,'id_orders'=>$modelOrders->id_orders];
                    //Передаем данные в фармате json пользователю
                    return $items;
                }else{
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['0','msg'=>'Возможно заказа нет или клиента в БД'];
                    //Передаем данные в фармате json пользователю
                    return $items;
                }
            }else{
                //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                //Фармируем массив с ошибкой
                $items = ['0','msg'=>'Ошибки в переданных данных на сервер'];
                //Передаем данные в фармате json пользователю
                return $items;
            }
        }else{
            //Если запрос был не AJAX делаем переадрисацю на главную страницу user
            return $this->redirect(['index']);
        }    
    }
}
