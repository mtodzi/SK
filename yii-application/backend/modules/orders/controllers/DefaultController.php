<?php

namespace backend\modules\orders\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\orders\models\OrdersSearch;
use backend\modules\orders\models\SearchInputOrders;
use backend\modules\orders\models\SearchClientsSubstitution;
use backend\modules\orders\models\SearchBrendSubstitution;
use backend\modules\orders\models\SearchDeviceTypeSubstitution;
use backend\modules\orders\models\SearchDeviceSubstitution;
use backend\modules\orders\models\Brands;
use backend\modules\orders\models\DeviceType;
use backend\modules\orders\models\SearchSerialNumbers;

/**
 * Default controller for the `orders` module
 */
class DefaultController extends Controller
{
    /**
     * Выводит все заказы которые не в архиве
     * @return string
     */
    public function actionIndex(){
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
     *Метод возврашает Список Имен клиентов при наборе в поле device_type     
     * 
     */
    public function actionTakedevicetype(){
        if(\Yii::$app->request->isAjax){
            $modelSearchInputOrders =  new SearchInputOrders(['scenario' => SearchInputOrders::SCENARIO_DEVICE_TYPE]);
            if($modelSearchInputOrders->load(Yii::$app->request->post()) && $modelSearchInputOrders->validate()){
                $id_orders = $modelSearchInputOrders->id_orders;
                $model_device_type = $modelSearchInputOrders->SearchDeviceType();
                if($model_device_type){
                    $select = $this->renderAjax('selectdevicetype', ['model_device_type'=>$model_device_type,'id_orders'=>$id_orders]);
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
     *Метод возврашает Список Имен клиентов при наборе в поле device_model     
     * 
     */
    public function actionTakedevicemodel(){
        if(\Yii::$app->request->isAjax){
            $modelSearchInputOrders =  new SearchInputOrders(['scenario' => SearchInputOrders::SCENARIO_DEVICES_MODEL]);
            if($modelSearchInputOrders->load(Yii::$app->request->post()) && $modelSearchInputOrders->validate()){
                $id_orders = $modelSearchInputOrders->id_orders;
                $model_devices_model = $modelSearchInputOrders->SearchDevicesModel();
                if($model_devices_model){
                    $select = $this->renderAjax('selectddevicesmodel', ['model_devices_model'=>$model_devices_model,'id_orders'=>$id_orders]);
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
     *Метод возврашает Список Имен клиентов при наборе в поле serial_numbers_name     
     * 
     */
    public function actionTakeserialnumbersname(){
        if(\Yii::$app->request->isAjax){
            $modelSearchInputOrders =  new SearchInputOrders(['scenario' => SearchInputOrders::SCENARIO_SEREIAL_NUMBERS]);
            if($modelSearchInputOrders->load(Yii::$app->request->post()) && $modelSearchInputOrders->validate()){
                $id_orders = $modelSearchInputOrders->id_orders;
                $model_serial_numbers_name = $modelSearchInputOrders->SearchSerialNnumbersName();
                if($model_serial_numbers_name){
                    $select = $this->renderAjax('selectdserialnumbersname', ['model_serial_numbers_name'=>$model_serial_numbers_name,'id_orders'=>$id_orders]);
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
                if(($modelOrders || $SearchBrendSubstitution->id_orders==0) && $modelBrand){
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
                $items = ['0','msg'=>'Ошибки в переданных данных на сервер','model'=>$SearchBrendSubstitution->getErrors()];
                //Передаем данные в фармате json пользователю
                return $items;
            }
        }else{
            //Если запрос был не AJAX делаем переадрисацю на главную страницу user
            return $this->redirect(['index']);
        }    
    }
    
    /*
     *Метод возврашает выбранный тип устройства из списка типа устройств 
     * 
     */
    public function actionTakedevicet(){
        if(\Yii::$app->request->isAjax){
            $SearchDeviceTypeSubstitution =  new SearchDeviceTypeSubstitution();
            if($SearchDeviceTypeSubstitution->load(Yii::$app->request->post()) && $SearchDeviceTypeSubstitution->validate()){
                $modelOrders = $SearchDeviceTypeSubstitution->SearchOrders();
                $modelDeviceTypeName = $SearchDeviceTypeSubstitution->SearchDeviceType();
                if(($modelOrders || $SearchDeviceTypeSubstitution->id_orders==0) && $modelDeviceTypeName){
                    $viewdevicetypeform = $this->renderAjax('devicetypenameindex', ['modelOrders'=>$modelOrders,'modelDeviceTypeName'=>$modelDeviceTypeName]);
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['200','msg'=>$viewdevicetypeform,'id_orders'=>(($modelOrders)?$modelOrders->id_orders:"0")];
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
                $items = ['0','msg'=>'Ошибки в переданных данных на сервер','model'=>$SearchDeviceTypeSubstitution->getErrors()];
                //Передаем данные в фармате json пользователю
                return $items;
            }
        }else{
            //Если запрос был не AJAX делаем переадрисацю на главную страницу user
            return $this->redirect(['index']);
        }    
    }
    
    /*
     *Метод возврашает выбранный тип устройства из списка типа устройств 
     * 
     */
    public function actionTakedevices(){
        if(\Yii::$app->request->isAjax){
            $SearchDeviceSubstitution =  new SearchDeviceSubstitution();
            if($SearchDeviceSubstitution->load(Yii::$app->request->post()) && $SearchDeviceSubstitution->validate()){
                $modelOrders = $SearchDeviceSubstitution->SearchOrders();
                $modelDevices = $SearchDeviceSubstitution->SearchDevices();
                if(($modelOrders || $SearchDeviceSubstitution->id_orders==0) && $modelDevices){
                    $modelBrend = Brands::findOne($modelDevices->brands_id);
                    $modelDeviceTypeName = DeviceType::findOne($modelDevices->devices_type_id);
                    if($modelBrend!==null &&  $modelDeviceTypeName!==null){
                        $viewdevicesform = $this->renderAjax('devicesindex', 
                            [   'modelOrders' =>$modelOrders,
                                'modelBrend' => $modelBrend,
                                'modelDeviceTypeName' => $modelDeviceTypeName,
                                'modelDevices' => $modelDevices,
                            ]); 
                        //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        //Фармируем массив с ошибкой
                        $items = ['200','msg'=>$viewdevicesform,'id_orders'=>(($modelOrders)?$modelOrders->id_orders:"0")];
                        //Передаем данные в фармате json пользователю
                        return $items;
                    }else{
                        //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        //Фармируем массив с ошибкой
                        $items = ['0','msg'=>'Возможно заказа нет или бренда или типа устройства в БД'];
                        //Передаем данные в фармате json пользователю
                        return $items;
                    }    
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
                $items = ['0','msg'=>'Ошибки в переданных данных на сервер','model'=>$SearchDeviceSubstitution->getErrors()];
                //Передаем данные в фармате json пользователю
                return $items;
            }
        }else{
            //Если запрос был не AJAX делаем переадрисацю на главную страницу user
            return $this->redirect(['index']);
        }    
    }
    
    /*
     *Метод возврашает выбранный тип устройства из списка типа устройств 
     * 
     */
    public function actionTakeserialnumbers(){
        if(\Yii::$app->request->isAjax){
            $SearchSerialNumbers =  new SearchSerialNumbers();
            if($SearchSerialNumbers->load(Yii::$app->request->post()) && $SearchSerialNumbers->validate()){
                $modelOrders = $SearchSerialNumbers->SearchOrders();
                $modelSerialNumbers = $SearchSerialNumbers->SearchSerialNumbers();
                if(($modelOrders || $SearchSerialNumbers->id_orders==0) && $modelSerialNumbers){;
                        $viewserialnumbersform = $this->renderAjax('serrialnambersid', ['model' => $modelOrders,'modelSerialNumbers'=>$modelSerialNumbers]); 
                        //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        //Фармируем массив с ошибкой
                        $items = ['200','msg'=>$viewserialnumbersform,'id_orders'=>(($modelOrders)?$modelOrders->id_orders:"0")];
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
                $items = ['0','msg'=>'Ошибки в переданных данных на сервер','model'=>$SearchDeviceSubstitution->getErrors()];
                //Передаем данные в фармате json пользователю
                return $items;
            }
        }else{
            //Если запрос был не AJAX делаем переадрисацю на главную страницу user
            return $this->redirect(['index']);
        }    
    }
}
