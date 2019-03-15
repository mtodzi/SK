<?php
    use yii\helpers\Html;
?>

<p class='form-row my-2 mx-2'> 
    <textarea class='form-row input_orders_special_notes input_orders' style='resize: none;' rows="3" cols="70"
             id='input_orders_special_notes-<?=(($model!=null)?$model->id_orders:0)?>' 
             name='OrdersEdit[special_notes]' data-input-name = "special_notes" form=''  
             autofocus maxlength="300" placeholder="Особые заметки"></textarea></p>
<p id = 'error_orders_special_notes-<?=(($model!=null)?$model->id_orders:0)?>' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
