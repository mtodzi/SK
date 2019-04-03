<?php

namespace backend\modules\orders\models;

use Yii;
use yii\base\Model;
use backend\modules\orders\models\OrdersClamedMalfunction;
use backend\modules\orders\models\ClaimedMalfunction;
use backend\modules\orders\models\ChangesTables;

class MalfunctionEdit extends Model{

    public $malfunction = array();
    public $claimed_malfunction_id = array();
    
    public function rules(){
        return [
            ['malfunction', 'each', 'rule' => ['required','message' => 'Одна или более введенная заявленная неисправность пуста.']],
            ['malfunction', 'each', 'rule' => ['string', 'max' => 255 ,'message' => 'Вы неправильно ввели один или более заявленных неисправностей.']],
            ['malfunction','validateMalfunctionCompare'],
            
            ['claimed_malfunction_id', 'each', 'rule' => ['required']],
            ['claimed_malfunction_id', 'each', 'rule' => ['integer']],
        ];           
    }
    
    /*
     *Метод проверяет совпадают ли телефоны
     *
     */
    public function validateMalfunctionCompare($attribute, $params)
    {
        $i = 0;
        foreach ($this->malfunction as $data){
            if($i == 0){
                $test = $data;                
            }else{
                if(strcasecmp($test,$data)== 0){
                    $this->addError($attribute, 'Одна из введенных заявленных неисправностей совпадает.');
                }
            }
            $i++;
        }
    }
    
    public function saveMalfunction($orders){
        if(!empty($orders)){
            foreach ($this->claimed_malfunction_id as $key => $claimed_malfunction_id){
                if($claimed_malfunction_id == 0){
                    $modelClaimedMalfunction = new ClaimedMalfunction();
                    $modelClaimedMalfunction->claimed_malfunction_name = $this->malfunction[$key];
                    if($modelClaimedMalfunction->save()){
                        $modelChangesTables = new ChangesTables('claimed_malfunction',$orders->id_orders,'Была создана новая заявленная неисправность - '.$modelClaimedMalfunction->claimed_malfunction_name.' для заказа', Yii::$app->user->identity->id);
                        $modelChangesTables->save();
                        $modelOrdersClamedMalfunctionNew = new OrdersClamedMalfunction();
                        $modelOrdersClamedMalfunctionNew->orders_id = $orders->id_orders;
                        $modelOrdersClamedMalfunctionNew->claimed_malfunction_id = $modelClaimedMalfunction->id_claimed_malfunction;
                        if($modelOrdersClamedMalfunctionNew->save()){
                            $modelChangesTables = new ChangesTables('orders_clamed_malfunction',$orders->id_orders,'Была добавленна новая заявленная неисправность - '.$modelClaimedMalfunction->claimed_malfunction_name.' для заказа', Yii::$app->user->identity->id);
                            $modelChangesTables->save();
                        }
                        $this->claimed_malfunction_id[$key]=$modelClaimedMalfunction->id_claimed_malfunction; 
                    }
                }else{
                    $modelOrdersClamedMalfunction = OrdersClamedMalfunction::findOne(['orders_id'=>$orders->id_orders, 'claimed_malfunction_id'=>$claimed_malfunction_id]);
                    if(empty($modelOrdersClamedMalfunction)){
                        $modelOrdersClamedMalfunctionNew = new OrdersClamedMalfunction();
                        $modelOrdersClamedMalfunctionNew->orders_id = $orders->id_orders;
                        $modelOrdersClamedMalfunctionNew->claimed_malfunction_id = $claimed_malfunction_id;
                        if($modelOrdersClamedMalfunctionNew->save()){
                            $modelChangesTables = new ChangesTables('orders_clamed_malfunction',$orders->id_orders,'Была добавленна новая заявленная неисправность - '.$modelOrdersClamedMalfunctionNew->claimedMalfunction->claimed_malfunction_name.' для заказа', Yii::$app->user->identity->id);
                            $modelChangesTables->save();
                        }
                    }
                }
            }    
            $modelOrdersClamedMalfunction = OrdersClamedMalfunction::findAll(['orders_id'=>$orders->id_orders]);
            foreach ($modelOrdersClamedMalfunction as $data){
                $j = 0;
                foreach ($this->claimed_malfunction_id as $value){
                    if($data->claimed_malfunction_id == $value){
                        $j++;
                    }
                }
                if($j==0){
                    $modelClamedMalfunction = $data->claimedMalfunction->claimed_malfunction_name;
                    OrdersClamedMalfunction::deleteAll(['orders_id'=>$orders->id_orders, 'claimed_malfunction_id'=>$data->claimed_malfunction_id]);
                    $modelChangesTables = new ChangesTables('orders_clamed_malfunction',$orders->id_orders,'Была удалена заявленная неисправность - '.$modelClamedMalfunction.' из заказа', Yii::$app->user->identity->id);
                    $modelChangesTables->save();
                }
            }
            return true;
        }else{
            return null;
        }
    }

        public function attributeLabels() {
        return
        [
            'claimed_malfunction_id'=>'Ключ заявленной неисправности',
            'malfunction'=>'Заявленная неисправность',            
        ];
    }
    
}
