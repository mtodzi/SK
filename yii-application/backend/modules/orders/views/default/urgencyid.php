<?php
    use yii\helpers\Html;
?>
<div class='form-check form-check-inline'>
    <input class='form-check-input check_urgency' <?=(($model!=null && $model->urgency == 1)?'checked':'')?>  type='checkbox' id='input_orders_urgency-<?=(($model!=null)?$model->id_orders:0)?>' >
    <label class='form-check-label' for='check_urgency-'> срочно! </label>
    <?php $id = 'orders_urgency-'.(($model!=null)?$model->id_orders:0);?>
    <?=Html :: hiddenInput('OrdersEdit[urgency]', (($model!=null)?$model->urgency:0), ['id'=>$id, 'form'=>'form_orders-'.(($model!=null)?$model->id_orders:0)])?>
</div>
