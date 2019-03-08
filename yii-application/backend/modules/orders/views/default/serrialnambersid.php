<?php
    use yii\helpers\Html;
    use backend\modules\orders\models\Brands;
    use backend\modules\orders\models\DeviceType;
    use backend\modules\orders\models\Devices;
    use backend\modules\orders\models\SerialNumbers;
    
    if($model == null && $modelSerialNumbers == null){
        $modelDeviceTypeName = null;
        $modelBrend = null;
        $modelDevices = null;
        $modelSerialNumbers=null;
        $modelOrders = $model;
    }
    if($model != null && $modelSerialNumbers != null){
        $modelBrend = Brands::findOne($model->serrialNambers->devise->brands->id_brands);
        $modelDeviceTypeName = DeviceType::findOne($model->serrialNambers->devise->devicesType->id_device_type);
        $modelDevices = Devices::findOne($model->serrialNambers->devise->id_devices);
        $modelSerialNumbers = $modelSerialNumbers;
        $modelOrders = $model;
    }
    if($model != null && $modelSerialNumbers == null){
        $modelBrend = Brands::findOne($model->serrialNambers->devise->brands->id_brands);
        $modelDeviceTypeName = DeviceType::findOne($model->serrialNambers->devise->devicesType->id_device_type);
        $modelDevices = Devices::findOne($model->serrialNambers->devise->id_devices);
        $modelSerialNumbers = SerialNumbers::findOne($model->serrialNambers->id_serial_numbers);
        $modelOrders = $model;
    }
    if($model == null && $modelSerialNumbers != null){
        $modelDeviceTypeName = DeviceType::findOne($modelSerialNumbers->devise->devicesType->id_device_type);;
        $modelBrend = Brands::findOne($modelSerialNumbers->devise->brands->id_brands);
        $modelDevices = Devices::findOne($modelSerialNumbers->devise->id_devices);
        $modelSerialNumbers=$modelSerialNumbers;
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

