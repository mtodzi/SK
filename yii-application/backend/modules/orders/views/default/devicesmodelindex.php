<?php
    use yii\helpers\Html;
?>

<p class="form-row my-2"> 
    <input id='input_orders_devices_model-<?=(($modelOrders!=null)?$modelOrders->id_orders:0)?>' 
        name='DevicesEdit[devices_model]' data-input-name = "devices_model"  form='form_orders-<?=(($modelOrders!=null)?$modelOrders->id_orders:0)?>' 
        class="form-control col-4 mx-2 input_orders_devices_model input_orders"
        value="<?=(($modelDevices!=null)?$modelDevices->devices_model:'')?>"
        type="text" placeholder="Модель устройства">
    <?php $id = 'orders_id_devices-'.(($modelOrders!=null)?$modelOrders->id_orders:0);?>
    <?=Html :: hiddenInput('DevicesEdit[id_devices]', (($modelDevices!=null)?$modelDevices->id_devices:0), ['id'=>$id,'form'=>'form_orders-'.(($modelOrders!=null)?$modelOrders->id_orders:0)])?>
</p>
<p id = 'error_orders_devices_model-<?=(($modelOrders!=null)?$modelOrders->id_orders:0)?>' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>

