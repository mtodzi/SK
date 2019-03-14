<?php
    use yii\helpers\Html;
?>

<p class="form-row my-2">
    <input id='input_orders_appearance-<?=(($model!=null)?$model->id_orders:0)?>' 
           name='OrdersEdit[appearance]' data-input-name = "appearance" form='' 
           class="form-control col-10 mx-2 input_orders_appearance input_orders"
           value="<?=(($model!=null)?$model->appearance:'')?>"
           type="text" placeholder="Внешний вид"> 
</p>
<p id = 'error_orders_appearance-<?=(($model!=null)?$model->id_orders:0)?>' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>

