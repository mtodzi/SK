<?php

namespace backend\modules\orders\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\orders\models\OrdersSearch;
use backend\modules\orders\models\Clients;

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
    public function actionTakenameclient(){
        $model_clients = Clients::find()->where(['LIKE', 'clients_name',(Yii::$app->request->post('name').'%'),FALSE])->all();        
        $select = $this->renderAjax('select', ['model_clients'=>$model_clients]);
        //Вызываем метод Yii где задаем что ответ должен быть в формате JSON
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //Фармируем массив с ошибкой
        $items = ['0','msg'=>$select];
        //Передаем данные в фармате json пользователю
        return $items;
    }
}
