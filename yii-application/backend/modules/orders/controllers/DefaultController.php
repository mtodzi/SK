<?php

namespace backend\modules\orders\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\orders\models\OrdersSearch;
use backend\modules\orders\models\SearchInputOrders;
use backend\modules\orders\models\SearchClientsSubstitution;
use backend\modules\orders\models\SearchBrendSubstitution;

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
     *Метод возврашает Список брендов     
     * 
     */
    public function actionTakenamebrands(){
        if(\Yii::$app->request->isAjax){
            $modelSearchInputOrders =  new SearchInputOrders(['scenario' => SearchInputOrders::SCENARIO_BREND]);
            if($modelSearchInputOrders->load(Yii::$app->request->post()) && $modelSearchInputOrders->validate()){
                $id_orders = $modelSearchInputOrders->id_orders;
                $model_brend = $modelSearchInputOrders->SearchBrandName();
                if($model_brend){
                    $select = $this->renderAjax('selectbrend', ['model_brend'=>$model_brend,'id_orders'=>$id_orders]);
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
     *Метод возврашает Список Имен клиентов при наборе в поле телефон    
     * 
     */
    public function actionTakephonenumber(){
        if(\Yii::$app->request->isAjax){
            $modelSearchInputOrders =  new SearchInputOrders(['scenario' => SearchInputOrders::SCENARIO_PHONE]);
            if($modelSearchInputOrders->load(Yii::$app->request->post()) && $modelSearchInputOrders->validate()){
                $id_orders = $modelSearchInputOrders->id_orders;
                $model_phone = $modelSearchInputOrders->SearchPhoneNumber();
                if($model_phone){
                    $select = $this->renderAjax('selectphone', ['model_phone'=>$model_phone,'id_orders'=>$id_orders]);
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
     *Метод возврашает Список Имен клиентов при наборе в поле     
     * 
     */
    public function actionTakeemailclient(){
        if(\Yii::$app->request->isAjax){
            $modelSearchInputOrders =  new SearchInputOrders(['scenario' => SearchInputOrders::SCENARIO_EMAIL]);
            if($modelSearchInputOrders->load(Yii::$app->request->post()) && $modelSearchInputOrders->validate()){
                $id_orders = $modelSearchInputOrders->id_orders;
                $model_clients = $modelSearchInputOrders->SearchClientsEmail();
                if($model_clients){
                    $select = $this->renderAjax('selectemail', ['model_clients'=>$model_clients,'id_orders'=>$id_orders]);
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
                    $items = ['200','msg'=>$viewclientform,'id_orders'=>(($modelOrders)?$modelOrders->id_orders:"0")];
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
    
    /*
     *Метод возврашает выбранный Бренд из списка Брендов 
     * 
     */
    public function actionTakebrend(){
        if(\Yii::$app->request->isAjax){
            $SearchBrendSubstitution =  new SearchBrendSubstitution();
            if($SearchBrendSubstitution->load(Yii::$app->request->post()) && $SearchBrendSubstitution->validate()){
                $modelOrders = $SearchBrendSubstitution->SearchOrders();
                $modelBrand = $SearchBrendSubstitution->SearchBrand();
                if(($modelOrders || $SearchBrendSubstitution->id_orders==0) && $modelClients){
                    $viewbrandform = $this->renderAjax('brendindex', ['modelOrders'=>$modelOrders,'modelBrend'=>$modelBrand]);
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['200','msg'=>$viewbrandform,'id_orders'=>(($modelOrders)?$modelOrders->id_orders:"0")];
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
