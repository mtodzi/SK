<?php

namespace common\models;

use Yii;
use backend\modules\developer\models\Controler;
use backend\modules\developer\models\ActionCt;
use backend\modules\acsess\models\Acsess;




class AcsessCo
{
    public static function getAcsess($id_user,$controler){
        $id_controler = Controler::findOne(['name_controler'=>$controler]);
        
        $actionct = ActionCt::find()
                                ->select('id')
                                ->where(['id_controler'=>$id_controler->id])
                                ->asArray()
                                ->all();
        
        $var = array();
        $array = array();				
        foreach ($actionct as $data){
            $var[] = $data['id'];			
        }
        
        $arrRole = \Yii::$app->authManager->getRolesByUser($id_user);
        $arRoleUser = array_keys($arrRole);
        $i = 0;
        foreach ($arRoleUser as $data){
            foreach ($var as $value){
                $model = Acsess::findOne(['item_name'=>$data,'id_action_ct'=>$value]);
                $array[$i]['actions'][]= $model->idActionCt->action_name;
                $array[$i]['allow'] =  $model->rows;   
                $array[$i]['roles'][] = $model->item_name;
                $i++;
            }
        } 
       return $array;
    }
    public static function getAcsessAction($controler){
        $id_controler = Controler::findOne(['name_controler'=>$controler]);
        
        $actionct = ActionCt::find()
                                ->where(['id_controler'=>$id_controler->id])
                                ->all();
        
        $var = array();
        foreach ($actionct as $data){
            $var[] = $data->action_name;
        }
        return $var;
    }
}    
