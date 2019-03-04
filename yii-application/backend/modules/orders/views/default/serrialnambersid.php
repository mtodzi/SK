<?php
    use yii\helpers\Html;
    use backend\modules\orders\models\Brands;
    use backend\modules\orders\models\DeviceType;
    
    if($model!=null){
        if($model->serrialNambers->devise->brands->id_brands!=0 && $model->serrialNambers->devise->devicesType->id_device_type!=0){
            $modelBrend = Brands::findOne($model->serrialNambers->devise->brands->id_brands);
            $modelDeviceTypeName = DeviceType::findOne($model->serrialNambers->devise->devicesType->id_device_type);
            $modelOrders = $model;
        }else{
            $modelDeviceTypeName = null;
            $modelBrend = null;
            $modelOrders = $model;
        }
    }else{
        $modelDeviceTypeName = null;
        $modelBrend = null;
        $modelOrders = $model;
    }
?>
<div id = "div_orders_brand_name-<?=(($model!=null)?$model->id_orders:0)?>">
    <?=$this->render('brendindex', ['modelBrend' => $modelBrend,'modelOrders' =>$modelOrders])?>
</div>
<div id = "div_orders_device_type_name-<?=(($model!=null)?$model->id_orders:0)?>">
    <?=$this->render('devicetypenameindex', ['modelDeviceTypeName' => $modelDeviceTypeName,'modelOrders' =>$modelOrders])?>
</div>
<?php $id = 'orders_hidden_serrial_nambers_id-'.(($model!=null)?$model->id_orders:0);?>
<?=Html :: hiddenInput('OrdersEdit[serrial_nambers_id]', (($model!=null)?$model->serrial_nambers_id:0), ['id'=>$id])?>

