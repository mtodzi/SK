<?php
    use yii\helpers\Html;
?>

<p class="form-row my-2"> 
    <input id='input_orders_device_type_name-<?=(($modelOrders!=null)?$modelOrders->id_orders:0)?>' 
        name='OrdersEdit[device_type_name]' data-input-name = "device_type_name"  form='' 
        class="form-control col-6 mx-2 input_device_type_name input_orders"
        value="<?=(($modelDeviceTypeName!=null)?$modelDeviceTypeName->device_type_name:'')?>"
        type="text" placeholder="Тип устройства">
    <?php $id = 'orders_id_device_type-'.(($modelOrders!=null)?$modelOrders->id_orders:0);?>
    <?=Html :: hiddenInput('OrdersEdit[id_device_type]', (($modelDeviceTypeName!=null)?$modelDeviceTypeName->id_device_type:0), ['id'=>$id])?>
</p>
<p id = 'error_orders_device_type_name-<?=(($modelOrders!=null)?$modelOrders->id_orders:0)?>' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>