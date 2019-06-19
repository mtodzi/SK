<?php

namespace backend\modules\stock\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\stock\models\Stocks;
use backend\modules\stock\models\StocksEdit;
use backend\modules\stock\models\EquipmentStockSearch;
use backend\modules\stock\models\SearchInput;
use backend\modules\stock\models\BrandsEdit;
use backend\modules\stock\models\DeviceTypeEdit;
use backend\modules\stock\models\DevicesEdit;
use backend\modules\stock\models\SerialNumbersEdit;
use backend\modules\stock\models\EquipmentStockEdit;

/**
 * Default controller for the `stock` module
 */
class StocksController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     * $id идентефекатор склада
     */
    public function actionIndex($id = 1)
    {
        $StocksModel = Stocks::find()->All();
        $searchModel = new EquipmentStockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);
        return $this->render('index',['StocksModel'=>$StocksModel, 'id'=>$id, 'searchModel'=>$searchModel, 'dataProvider'=>$dataProvider]);
    }
    
    public function actionCreatestock(){
        if(\Yii::$app->request->isAjax){
            //Создаем новый обьект для добовления 
            $modelStocksEdit = new StocksEdit(['scenario' => StocksEdit::SCENARIO_CREATE]);
            if ($modelStocksEdit->load(Yii::$app->request->post()) && $modelStocksEdit->validate()){
                $modelStocksEdit = $modelStocksEdit->saveStock();
                if($modelStocksEdit!=null){
                    $StocksModel = Stocks::find()->All();
                    $searchModel = new EquipmentStockSearch();
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$modelStocksEdit->id_stocks);
                    $htmlStocks = $this->renderAjax('get_select_stock', ['StocksModel' => $StocksModel,'id'=>$modelStocksEdit->id_stocks]);
                    $htmlSerialNamber = $this->renderAjax('serialnumbers_in_stock', ['dataProvider' => $dataProvider]);
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['200','msg'=>"Вы добавили новый склад ", 'htmlStocks'=>$htmlStocks, 'htmlSerialNamber'=>$htmlSerialNamber,'id'=>$modelStocksEdit->id_stocks];
                    //Передаем данные в фармате json пользователю
                    return $items;
                }else{
                    //Если данные на загрузились в обьект и не прошли валидацию
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['0','msg'=>"По какой-то причине новый склад не был добавлен в БД обратитесь к администратору ", 'modelErrors'=>0];
                    //Передаем данные в фармате json пользователю
                    return $items;
                }
            }else{
                //Если данные на загрузились в обьект и не прошли валидацию
                //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                //Фармируем массив с ошибкой
                $items = ['0','msg'=>"Ошибка в заполненных полях", 'modelErrors'=>$modelStocksEdit->getErrors()];
                //Передаем данные в фармате json пользователю
                return $items;
            }
        }else{
            //Если запрос был не AJAX делаем переадрисацю на главную страницу user
            return $this->redirect(['index']);
        }
    }
    
    public function actionUpdatestock(){
        if(\Yii::$app->request->isAjax){
            //Создаем новый обьект для добовления 
            $modelStocksEdit = new StocksEdit(['scenario' => StocksEdit::SCENARIO_UPDATE]);
            if ($modelStocksEdit->load(Yii::$app->request->post()) && $modelStocksEdit->validate()){
                $modelStocksEdit = $modelStocksEdit->updateStock();
                if($modelStocksEdit!=null){                   
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['200','msg'=>"Вы отредактировали склад ", 'name_stock'=>$modelStocksEdit->name_stock, 'id_stocks'=>$modelStocksEdit->id_stocks];
                    //Передаем данные в фармате json пользователю
                    return $items;
                }else{
                    //Если данные на загрузились в обьект и не прошли валидацию
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['0','msg'=>"По какой-то причине новый склад не был добавлен в БД обратитесь к администратору ", 'modelErrors'=>0];
                    //Передаем данные в фармате json пользователю
                    return $items;
                }
            }else{
                //Если данные на загрузились в обьект и не прошли валидацию
                //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                //Фармируем массив с ошибкой
                $items = ['0','msg'=>"Ошибка в заполненных полях", 'modelErrors'=>$modelStocksEdit->getErrors()];
                //Передаем данные в фармате json пользователю
                return $items;
            }
        }else{
            //Если запрос был не AJAX делаем переадрисацю на главную страницу user
            return $this->redirect(['index']);
        }
    }
    /**
     * Метод будет добавлять продукт на склад
     */
    public function actionAddserialnambersinstock(){
        if(\Yii::$app->request->isAjax){
            $countError = 0;
            $errorsBrandsEdit = 0;
            $errorsDeviceTypeEdit = 0;
            $errorsDevicesEdit = 0;
            $errorsSerialNumbersEdit = 0;
            $errorsEquipmentStockEdit = 0;
            
            $modelBrandsEdit = new BrandsEdit();
            $modelDeviceTypeEdit = new DeviceTypeEdit();
            $modelDevicesEdit = new DevicesEdit();
            $modelSerialNumbersEdit = new SerialNumbersEdit();
            
            if($modelBrandsEdit->load(Yii::$app->request->post()) && !$modelBrandsEdit->validate()){
                $countError++;
                $errorsBrandsEdit = $modelBrandsEdit->getErrors();
            }
            
            if($modelDeviceTypeEdit->load(Yii::$app->request->post()) && !$modelDeviceTypeEdit->validate()){
                $countError++;
                $errorsDeviceTypeEdit = $modelDeviceTypeEdit->getErrors();
            }
            
            if($modelDevicesEdit->load(Yii::$app->request->post()) && !$modelDevicesEdit->validate()){
                $countError++;
                $errorsDevicesEdit = $modelDevicesEdit->getErrors();
            }
            switch (Yii::$app->request->post('type_addition')){
                case 'one':
                    $modelSerialNumbersEdit = new SerialNumbersEdit(['scenario' => SerialNumbersEdit::SCENARIO_SEREIAL_NUMBERS_ONE]);
                    $modelEquipmentStockEdit = new EquipmentStockEdit(['scenario' => EquipmentStockEdit::SCENARIO_EQUIPMENT_STOCK_ONE]);
                    break;
                case 'range':
                    $modelSerialNumbersEdit = new SerialNumbersEdit(['scenario' => SerialNumbersEdit::SCENARIO_SEREIAL_NUMBERS_RANGE]);
                    $modelEquipmentStockEdit = new EquipmentStockEdit(['scenario' => EquipmentStockEdit::SCENARIO_EQUIPMENT_STOCK_RANGE]);
                    break;
                case 'some':
                    $modelSerialNumbersEdit = new SerialNumbersEdit(['scenario' => SerialNumbersEdit::SCENARIO_SEREIAL_NUMBERS_SOME]);
                    break;
            }
            if($modelSerialNumbersEdit->load(Yii::$app->request->post()) && !$modelSerialNumbersEdit->validate()){
                $countError++;
                $errorsSerialNumbersEdit = $modelSerialNumbersEdit->getErrors();
            }
            if($modelEquipmentStockEdit->load(Yii::$app->request->post()) && !$modelEquipmentStockEdit->validate()){
                $countError++;
                $errorsEquipmentStockEdit = $modelEquipmentStockEdit->getErrors();
            }            
            if($countError == 0){
                $countErrorSave = 0;
                $msgCountErrorSave = 'Ошибки сохранения - ';
                switch (Yii::$app->request->post('type_addition')){
                    case 'one':
                        if($modelEquipmentStockEdit->serial_number_id != 0){
                            $resultSave = $modelEquipmentStockEdit->saveEquipmentStock();
                            if($resultSave['errror']==1){
                                $countErrorSave++;
                                $msgCountErrorSave = $msgCountErrorSave.$resultSave['msg'];
                            }
                        }else{
                            $resultSave = $this->NewSerialNambers($modelBrandsEdit,$modelDeviceTypeEdit,$modelDevicesEdit,$modelSerialNumbersEdit);
                            if($resultSave['errror']==1){
                                $countErrorSave++;
                                $msgCountErrorSave = $msgCountErrorSave.$resultSave['msg'];
                            }else{
                                $resultSave = $modelEquipmentStockEdit->saveEquipmentStockNewSirealNambers($resultSave['msg']);
                            }
                        }
                        break;
                case 'range':
                        $resultSave = $this->NewSerialNambersRange($modelBrandsEdit,$modelDeviceTypeEdit,$modelDevicesEdit,$modelSerialNumbersEdit);
                        if($resultSave['errror']==1){
                            $countErrorSave++;
                            $msgCountErrorSave = $msgCountErrorSave.$resultSave['msg'];
                        }else{
                            $resultSave = $modelEquipmentStockEdit->saveEquipmentStockNewSirealNambersRange($resultSave['msg']);
                        }    
                        break;
                case 'some':
                        
                        break;
                }
                $select = '';
                $msgSwitch = '';
                if($countErrorSave==0){
                    switch (Yii::$app->request->post('type_addition')){
                        case 'one':
                            $select = $this->renderAjax('serialnumbers', ['model' => $resultSave['msg'],]);
                            $textError = 0;
                            $msgSwitch = 'one';
                            break;
                        case 'range':
                            foreach ($resultSave['msg'] as $data){
                                $select = $select."<div class='' data-key='[]' >".($this->renderAjax('serialnumbers', ['model' => $data,]))."</div>";
                            }
                            if($resultSave['countError']!=0){
                                $textError = $resultSave['msgError'];
                            }else{
                                $textError = 0;
                            }    
                            $msgSwitch = 'range';
                            break;
                        case 'some':
                        
                            break;
                    }   
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['200','msg'=>$msgSwitch, 'txt'=>$select, 'textError'=>$textError];
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
                    'errorsBrandsEdit'=>$errorsBrandsEdit,
                    'errorsDeviceTypeEdit'=>$errorsDeviceTypeEdit,
                    'errorsSerialNumbersEdit'=>$errorsSerialNumbersEdit,
                    'errorsDevicesEdit'=>$errorsDevicesEdit,
                    'errorsEquipmentStockEdit'=>$errorsEquipmentStockEdit
                ];
                //Передаем данные в фармате json пользователю
                return $items;
            }
            //Если данные на загрузились в обьект и не прошли валидацию
            //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            //Фармируем массив с ошибкой
            $items = ['200','msg'=>"запрос верен" ];
            //Передаем данные в фармате json пользователю
            return $items;
        }else{
            //Если запрос был не AJAX делаем переадрисацю на главную страницу user
            return $this->redirect(['index']);
        }        
    }
    
    
    public function NewSerialNambers($modelBrandsEdit,$modelDeviceTypeEdit,$modelDevicesEdit,$modelSerialNumbersEdit){
        $modelBrandsEdit = $modelBrandsEdit->saveBrand();
        if($modelBrandsEdit['errror']==1){
            return array('errror'=>1,'msg'=>$modelBrandsEdit['msg']);
        }
        $modelDeviceTypeEdit = $modelDeviceTypeEdit->saveDeviceType();
        if($modelDeviceTypeEdit['errror']==1){
            return array('errror'=>1,'msg'=>$modelDeviceTypeEdit['msg']);
        }
        $modelDevicesEdit = $modelDevicesEdit->saveDevices($modelBrandsEdit['msg'],$modelDeviceTypeEdit['msg']);
        if($modelDevicesEdit['errror']==1){
            return array('errror'=>1,'msg'=>$modelDevicesEdit['msg']);
        }
        $modelSerialNumbersEdit = $modelSerialNumbersEdit->saveSerialNambers($modelDevicesEdit['msg']);
        if($modelSerialNumbersEdit['errror']==1){
            return array('errror'=>1,'msg'=>$modelSerialNumbersEdit['msg']);
        }else{
            return array('errror'=>0,'msg'=>$modelSerialNumbersEdit['msg']);
        }
        
    }
    
    public function NewSerialNambersRange($modelBrandsEdit,$modelDeviceTypeEdit,$modelDevicesEdit,$modelSerialNumbersEdit){
        $modelBrandsEdit = $modelBrandsEdit->saveBrand();
        if($modelBrandsEdit['errror']==1){
            return array('errror'=>1,'msg'=>$modelBrandsEdit['msg']);
        }
        $modelDeviceTypeEdit = $modelDeviceTypeEdit->saveDeviceType();
        if($modelDeviceTypeEdit['errror']==1){
            return array('errror'=>1,'msg'=>$modelDeviceTypeEdit['msg']);
        }
        $modelDevicesEdit = $modelDevicesEdit->saveDevices($modelBrandsEdit['msg'],$modelDeviceTypeEdit['msg']);
        if($modelDevicesEdit['errror']==1){
            return array('errror'=>1,'msg'=>$modelDevicesEdit['msg']);
        }
        $modelSerialNumbersEdit = $modelSerialNumbersEdit->saveSerialNambersRange($modelDevicesEdit['msg']);
        if($modelSerialNumbersEdit['errror']==1){
            return array('errror'=>1,'msg'=>$modelSerialNumbersEdit['msg']);
        }else{
            return array('errror'=>0,'msg'=>$modelSerialNumbersEdit['msg']);
        }
    }

    /*
     *Метод возврашает выбранный Бренд из списка Брендов 
     * 
     */
    public function actionTaketxtinput(){
        if(\Yii::$app->request->isAjax){
            $data_input_name = Yii::$app->request->post('data-input-name');
            $type_addition =  Yii::$app->request->post('type_addition');
            switch ($data_input_name){
                case 'name_brands':
                    $modelSearchInput =  new SearchInput(['scenario' => SearchInput::SCENARIO_BREND]);
                    break;
                case 'device_type_name':
                    $modelSearchInput =  new SearchInput(['scenario' => SearchInput::SCENARIO_DEVICE_TYPE]);
                    break;
                case 'devices_model':
                    $modelSearchInput =  new SearchInput(['scenario' => SearchInput::SCENARIO_DEVICES_MODEL]);
                    break;
                case 'serial_numbers_name':
                    $modelSearchInput =  new SearchInput(['scenario' => SearchInput::SCENARIO_SEREIAL_NUMBERS]);
                    break;
            }            
            if($modelSearchInput->load(Yii::$app->request->post()) && $modelSearchInput->validate()){
                $id_serial_numbers = $modelSearchInput->id_serial_numbers;
                switch ($data_input_name){
                    case 'name_brands':
                        $model = $modelSearchInput->SearchBrandName();
                        break;
                    case 'device_type_name':
                        $model = $modelSearchInput->SearchDeviceType();
                        break;
                    case 'devices_model':
                        $model = $modelSearchInput->SearchDevicesModel();
                        break;
                    case 'serial_numbers_name':
                        $model = $modelSearchInput->SearchSerialNnumbersName();
                        break;
                }                
                if($model){
                    switch ($data_input_name){
                        case 'name_brands':
                            $select = $this->renderAjax('select', ['model'=>$model,'id_serial_numbers'=>$id_serial_numbers, 'data_input_name'=>$data_input_name]);
                            break;
                        case 'device_type_name':
                            $select = $this->renderAjax('select', ['model'=>$model,'id_serial_numbers'=>$id_serial_numbers, 'data_input_name'=>$data_input_name]);
                            break;
                        case 'devices_model':
                            $select = $this->renderAjax('select', ['model'=>$model,'id_serial_numbers'=>$id_serial_numbers, 'data_input_name'=>$data_input_name]);
                            break;
                        case 'serial_numbers_name':
                            $select = $this->renderAjax('select', ['model'=>$model,'id_serial_numbers'=>$id_serial_numbers, 'data_input_name'=>$data_input_name, 'type_addition'=>$type_addition]);
                            break;
                    }                    
                    //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    //Фармируем массив с ошибкой
                    $items = ['200','msg'=>$select,'id_serial_numbers'=>$id_serial_numbers];
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
}
