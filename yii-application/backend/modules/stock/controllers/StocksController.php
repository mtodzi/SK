<?php

namespace backend\modules\stock\controllers;

use yii\web\Controller;
use backend\modules\stock\models\Stocks;

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
        return $this->render('index',['StocksModel'=>$StocksModel, 'id'=>$id]);
    }
}
