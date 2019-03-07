<?php
    use yii\helpers\Html;
    use backend\modules\orders\models\Brands;
    use backend\modules\orders\models\DeviceType;
    use backend\modules\orders\models\Devices;
    use backend\modules\orders\models\SerialNumbers;
    
    if($model!=null){
        if($model->serrialNambers->devise->brands->id_brands!=0 
                && $model->serrialNambers->devise->devicesType->id_device_type!=0 
                && $model->serrialNambers->devise->id_devices!=0
                && $model->serrialNambers->id_serial_numbers!=0
        ){
            $modelBrend = Brands::findOne($model->serrialNambers->devise->brands->id_brands);
            $modelDeviceTypeName = DeviceType::findOne($model->serrialNambers->devise->devicesType->id_device_type);
            $modelDevices = Devices::findOne($model->serrialNambers->devise->id_devices);
            $modelSerialNumbers = SerialNumbers::findOne($model->serrialNambers->id_serial_numbers);;
            $modelOrders = $model;
        }else{
            $modelDeviceTypeName = null;
            $modelBrend = null;
            $modelDevices = null;
            $modelSerialNumbers=null;
            $modelOrders = $model;
        }
    }else{
        $modelDeviceTypeName = null;
        $modelBrend = null;
        $modelDevices = null;
        $modelSerialNumbers=null;
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
    <div id = "div_orders_serial_numbers_name-<?=(($modelOrders!=null)?$modelOrders->id_orders:0)?>">
        <?=$this->render('serialnumbersnameindex', ['modelSerialNumbers' => $modelSerialNumbers,'modelOrders' =>$modelOrders])?>
    </div>
</div>    
<?php $id = 'orders_hidden_serrial_nambers_id-'.(($model!=null)?$model->id_orders:0);?>
<?=Html :: hiddenInput('OrdersEdit[serrial_nambers_id]', (($model!=null)?$model->serrial_nambers_id:0), ['id'=>$id])?>

