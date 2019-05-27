<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div id = 'serialnumbers_content-<?=$model->serialNumber->id_serial_numbers?>'>
    <div class='col py-2'>
        <div class=''>
            <h5>
                <p class='form-row my-1'>Серийный номер продукта - <?=$model->serialNumber->serial_numbers_name?></p>
            </h5>
            <p class='form-row my-1'>Бренд продукта - <?=$model->serialNumber->devise->brands->name_brands?></p>
            <p class='form-row my-1'>Тип устройства - <?=$model->serialNumber->devise->devicesType->device_type_name?></p>
            <p class='form-row my-1'>Модель устройства - <?=$model->serialNumber->devise->devices_model?></p>
        </div>
    </div>
</div>