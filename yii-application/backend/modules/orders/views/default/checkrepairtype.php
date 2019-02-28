<?php
    use yii\helpers\Html;
?>
<div class='form-check form-check-inline'>
    <input class='form-check-input' type='checkbox' id='check_diagnostics-' value='option1'>
    <label class='form-check-label' for='check_diagnostics-'>диагностика</label>
</div>
<div class='form-check form-check-inline'>
    <input class='form-check-input' type='checkbox' id='check_repair-' value='option2'>
    <label class="form-check-label" for="check_repair-">ремонт</label>
</div>
<?=Html :: hiddenInput('OrdersEdit[repair_type]', (($model!=null)?$model->repair_type:0), [])?>
