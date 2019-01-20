<?php

namespace app\modules\acsess\controllers;

use Yii;
use backend\modules\acsess\models\Acsess;
use backend\modules\acsess\models\SearchAcsess;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\developer\models\Controler;
use backend\modules\developer\models\ActionCt;
use backend\modules\developer\models\SearchControler;
use yii\filters\AccessControl;
use common\models\AcsessCo;
/**
 * AcsessController implements the CRUD actions for Acsess model.
 */
class AcsessController extends Controller
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
                'only' => AcsessCo::getAcsessAction('acsess'),
                'rules' => AcsessCo::getAcsess(Yii::$app->user->identity->id,'acsess')                
            ]
        ];
    }

    /**
     * Lists all Acsess models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $cache = Yii::$app->cache;
        $role_id = "role".Yii::$app->user->id;
        $cache->delete($role_id);
        $cache->add($role_id, $id, 300);
        $searchModel = new SearchControler();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $id
        ]);
    }

    /**
     * Displays a single Acsess model.
     * @param integer $id
     * @return mixed
    
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
     * 
     */

    /**
     * Creates a new Acsess model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
      $role_id = "role".Yii::$app->user->id;
      $cache = Yii::$app->cache;
      $id_role = $cache->get($role_id);  
      $model = ActionCt::find()->where(['id_controler'=>$id])->all();
      //$i = 0;
      //$j = 0;
      foreach ($model as $data){
          $acsess = Acsess::findOne([
                                'item_name' => $id_role,
                                'id_action_ct' => $data->id,
                            ]);
          if(empty($acsess)){
              $create_acsess = new Acsess();
              $create_acsess->item_name = $id_role;
              $create_acsess->id_action_ct = $data->id;
              $create_acsess->rows = 0;
              $create_acsess->save();      
          }
      }
      return $this->redirect(['update','id'=>$id]);
      /*
      return $this->render('create', [
            'model' => $model,
            'id_role' => $id_role,
            'i' => $i,
            'j' => $j
        ]);
       * 
       */
    }

    /**
     * Updates an existing Acsess model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
      $role_id = "role".Yii::$app->user->id;
      $cache = Yii::$app->cache;
      $id_role = $cache->get($role_id);
      if(!empty($id_role)){
        $cache->delete($role_id);
        $cache->add($role_id, $id_role, 300);
        /*
        return $this->render('create', [
            'id_role' => $id_role,
            'id' => $id,
            ]);
        * 
        */
        $searchModel = new SearchAcsess();
        $dataProvider = $searchModel->searchRoleControle(Yii::$app->request->queryParams,$id,$id_role);
        return $this->render('update', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id_role' => $id_role
            ]); 
      }else{
          $this->redirect(['/acsess']);
      }
    }

    /**
     * Deletes an existing Acsess model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
     * 
     */

    
    public function actionAllow($id){
        $acsess = $this->findModel($id);
        $acsess->rows = 1;
        $acsess->save();
        $role_id = "role".Yii::$app->user->id;
        $cache = Yii::$app->cache;
        $id_role = $cache->get($role_id);
        if(empty($id_role)){
            $cache->delete($role_id);
            $cache->add($role_id, $acsess->item_name, 300); 
            $id_role = $cache->get($role_id);
        }
        return $this->redirect(['update','id'=>$acsess->idActionCt->id_controler]);
    }
    public function actionDeny($id){
        $acsess = $this->findModel($id);
        $acsess->rows = 0;
        $acsess->save();
        $role_id = "role".Yii::$app->user->id;
        $cache = Yii::$app->cache;
        $id_role = $cache->get($role_id);
        if(empty($id_role)){
            $cache->delete($role_id);
            $cache->add($role_id, $acsess->item_name, 300); 
            $id_role = $cache->get($role_id);
        }
        return $this->redirect(['update','id'=>$acsess->idActionCt->id_controler]);
    }
    /**
     * Finds the Acsess model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Acsess the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Acsess::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
