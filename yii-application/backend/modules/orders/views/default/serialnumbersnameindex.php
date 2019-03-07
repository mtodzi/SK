<?php
    use yii\helpers\Html;
?>

<p class="form-row my-2">
    <input id='input_serial_numbers_name-<?=(($modelOrders!=null)?$modelOrders->id_orders:0)?>' 
        name='OrdersEdit[serial_numbers_name]' data-input-name = "serial_numbers_name"  form=''
        class="form-control col-4 mx-2 input_orders_serial_numbers_name input_orders" type="text"
        value="<?=(($modelSerialNumbers!=null)?$modelSerialNumbers->serial_numbers_name:'')?>"
        placeholder="Серийный номер">
    <?php $id = 'orders_id_serial_numbers-'.(($modelOrders!=null)?$modelOrders->id_orders:0);?>
    <?=Html :: hiddenInput('OrdersEdit[id_serial_numbers]', (($modelSerialNumbers!=null)?$modelSerialNumbers->id_serial_numbers:0), ['id'=>$id])?>
</p>
<p id = 'error_orders_serial_numbers_name-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
