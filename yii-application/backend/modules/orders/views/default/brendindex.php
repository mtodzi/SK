<?php
    use yii\helpers\Html;
?>

<p class="form-row my-2"> 
    <input id='input_orders_brand_name-<?=(($modelOrders!=null)?$modelOrders->id_orders:0)?>' 
        name='OrdersEdit[name_brands]'  form='' 
        class="form-control col-4 mx-2 input_orders_brand_name"
        value="<?=(($modelBrend!=null)?$modelBrend->name_brands:'')?>"
        type="text" placeholder="Бренд">
    <?php $id = 'orders_id_brands-'.(($modelOrders!=null)?$modelOrders->id_orders:0);?>
    <?=Html :: hiddenInput('OrdersEdit[id_brands]', (($modelBrend!=null)?$modelBrend->id_brands:0), ['id'=>$id])?>
</p>
<p id = 'error_orders_brand_name-<?=(($modelOrders!=null)?$modelOrders->id_orders:0)?>' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>

