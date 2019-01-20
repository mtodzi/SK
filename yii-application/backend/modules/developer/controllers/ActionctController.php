<?php

namespace app\modules\developer\controllers;

use Yii;
use backend\modules\developer\models\ActionCt;
use backend\modules\developer\models\SearchActionCt;
use backend\modules\developer\models\Controler;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\AcsessCo;

/**
 * ActionctController implements the CRUD actions for ActionCt model.
 */
class ActionctController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => AcsessCo::getAcsessAction('actionct'),
                'rules' => AcsessCo::getAcsess(Yii::$app->user->identity->id,'actionct')                
            ]
        ];
    }

    /**
     * Lists all ActionCt models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchModel = new SearchActionCt();
        $model = Controler::findOne($id);
        $dataProvider = $searchModel->searchControler(Yii::$app->request->queryParams,$id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=> $model
        ]);
    }

    /**
     * Displays a single ActionCt model.
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
     * Creates a new ActionCt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new ActionCt();
        $controler = Controler::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'controler'=>$controler
            ]);
        }
    }

    /**
     * Updates an existing ActionCt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ActionCt model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $data = $model->id_controler; 
        $model->delete();

        return $this->redirect(['index','id'=>$data]);
    }

    /**
     * Finds the ActionCt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ActionCt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ActionCt::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
