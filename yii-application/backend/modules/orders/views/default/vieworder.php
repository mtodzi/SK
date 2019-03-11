<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div id = 'orders_content-<?=$model->id_orders?>'>
    <div class='col py-2'>
        <div class=''>
            <h5>
                <p class='form-row my-1'><?=$model->clients->clients_name?> // тел: <?=$model->getOnePhoneClient()?></p>
            </h5>
            <p class='form-row my-1'><?=$model->getRepairTypeString()?></p>
            <p class='form-row my-1'><?=$model->getDevicesText()?></p>
            <p class='form-row my-1'><?=$model->getOrdersClamedMalfunction()?></p>
        </div>
    </div>
</div>