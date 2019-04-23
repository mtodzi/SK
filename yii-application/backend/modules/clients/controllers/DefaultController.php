<?php

namespace backend\modules\clients\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\clients\models\ClientsSearch;

/**
 * Default controller for the `clients` module
 */
class DefaultController extends Controller
{
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
}
