<?php
    use yii\helpers\Html;
    use backend\modules\orders\models\Brands;
    use backend\modules\orders\models\DeviceType;
    use backend\modules\orders\models\Devices;
    
    if($model!=null){
        if($model->serrialNambers->devise->brands->id_brands!=0 && $model->serrialNambers->devise->devicesType->id_device_type!=0 && $model->serrialNambers->devise->id_devices!=0){
            $modelBrend = Brands::findOne($model->serrialNambers->devise->brands->id_brands);
            $modelDeviceTypeName = DeviceType::findOne($model->serrialNambers->devise->devicesType->id_device_type);
            $modelDevices = Devices::findOne($model->serrialNambers->devise->id_devices);
            $modelOrders = $model;
        }else{
            $modelDeviceTypeName = null;
            $modelBrend = null;
            $modelDevices = null;
            $modelOrders = $model;
        }
    }else{
        $modelDeviceTypeName = null;
        $modelBrend = null;
        $modelDevices = null;
        $modelOrders = $model;
    }
?>
<div id = "div_orders_devices-<?=(($model!=null)?$model->id_orders:0)?>">
    <?=$this->render('devicesindex', 
        [   'modelOrders' =>$modelOrders,
            'modelBrend' => $modelBrend,
            'modelDeviceTypeName' => $modelDeviceTypeName,
            'modelDevices' => $modelDevices,
        ])
    ?>    
</div>    
<?php $id = 'orders_hidden_serrial_nambers_id-'.(($model!=null)?$model->id_orders:0);?>
<?=Html :: hiddenInput('OrdersEdit[serrial_nambers_id]', (($model!=null)?$model->serrial_nambers_id:0), ['id'=>$id])?>

