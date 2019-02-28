<?php
    use yii\helpers\Html;
    use backend\modules\orders\models\Brands;
    
    if($model!=null){
        if($model->serrialNambers->devise->brands->id_brands!=0){
            $modelBrend = Brands::findOne($model->serrialNambers->devise->brands->id_brands);
            $modelOrders = $model;
        }else{
            $modelBrend = null;
            $modelOrders = $model;
        }
    }else{
        $modelBrend = null;
        $modelOrders = $model;
    }
?>
<div id = "div_orders_brand_name-<?=(($model!=null)?$model->id_orders:0)?>">
    <?=$this->render('brendindex', ['modelBrend' => $modelBrend,'modelOrders' =>$modelOrders])?>
</div>
<?php $id = 'orders_hidden_serrial_nambers_id-'.(($model!=null)?$model->id_orders:0);?>
<?=Html :: hiddenInput('OrdersEdit[serrial_nambers_id]', (($model!=null)?$model->serrial_nambers_id:0), ['id'=>$id])?>
