<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div id = 'clients_content-<?=$model->id_clients?>'>
    <div class='col py-2'>
        <div class=''>
            <h5>
                <p class='form-row my-1'><?=$model->clients_name?></p>
            </h5>
            <p class='form-row my-1'><img class='my_icon' src='<?=Url::to(['/img/mail.svg'])?>'><span id='span_clients_email-<?=$model->id_clients?>'><?=$model->clients_email?></span></p>
            <p class='form-row my-1'><img class='my_icon' src='<?=Url::to(['/img/smartphone-call.svg'])?>'><span id='span_clients_phone-<?=$model->id_clients?>'><?=$model->getFirstPhone()?></span></p>
            <p class='form-row my-1'><img class='my_icon' src='<?=Url::to(['/img/home.svg'])?>'><span id='span_clients_address-<?=$model->id_clients?>'><?=$model->clients_address?></span></p>
        </div>
    </div>
</div>