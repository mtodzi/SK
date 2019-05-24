<?php

namespace backend\modules\stock\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\stock\models\Stocks;
use backend\modules\stock\models\StocksEdit;
use backend\modules\stock\models\EquipmentStockSearch;

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
}
