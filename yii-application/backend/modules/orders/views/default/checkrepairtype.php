<?php
    use yii\helpers\Html;
?>
<div class='form-check form-check-inline'>
    <input class='form-check-input check_repair_type' type='checkbox' id='check_diagnostics-<?=(($model!=null)?$model->id_orders:0)?>' 
        <?=(($model!=null)?(($model->repair_type==1 || $model->repair_type==3)?'checked':''):'')?>>
    <label class='form-check-label' for='check_diagnostics-'>диагностика</label>
</div>
<div class='form-check form-check-inline'>
    <input class='form-check-input check_repair_type' type='checkbox' id='check_repair-<?=(($model!=null)?$model->id_orders:0)?>'
        <?=(($model!=null)?(($model->repair_type==2 || $model->repair_type==3)?'checked':''):'')?>>
    <label class="form-check-label" for="check_repair-">ремонт</label>
</div>
<?php $id = 'orders_hidden_repair_type-'.(($model!=null)?$model->id_orders:0);?>
<?=Html :: hiddenInput('OrdersEdit[repair_type]', (($model!=null)?$model->repair_type:0), ['id'=>$id])?>
