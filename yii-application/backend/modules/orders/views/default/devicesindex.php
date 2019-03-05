<?php
?>


    <div id = "div_orders_brand_name-<?=(($modelOrders!=null)?$modelOrders->id_orders:0)?>">
        <?=$this->render('brendindex', ['modelBrend' => $modelBrend,'modelOrders' =>$modelOrders])?>
    </div>
    <div id = "div_orders_device_type_name-<?=(($modelOrders!=null)?$modelOrders->id_orders:0)?>">
        <?=$this->render('devicetypenameindex', ['modelDeviceTypeName' => $modelDeviceTypeName,'modelOrders' =>$modelOrders])?>
    </div>
    <div id = "div_orders_devices_model-<?=(($modelOrders!=null)?$modelOrders->id_orders:0)?>">
        <?=$this->render('devicesmodelindex', ['modelDevices' => $modelDevices,'modelOrders' =>$modelOrders])?>
    </div>

