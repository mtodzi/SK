<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div id = 'serialnumbers_content-<?=$model->serialNumber->id_serial_numbers?>'>
    <div class='col py-2'>
        <div class=''>
            <h5>
                <p class='form-row my-1'>Серийный номер продукта - <span id = 'span_serial_numbers_name-<?=$model->serialNumber->id_serial_numbers?>'><?=$model->serialNumber->serial_numbers_name?></span></p>
            </h5>
            <p class='form-row my-1'>Бренд продукта - <span id = 'span_name_brands-<?=$model->serialNumber->id_serial_numbers?>'><?=$model->serialNumber->devise->brands->name_brands?></span></p>
            <p class='form-row my-1'>Тип устройства - <span id = 'span_device_type_name-<?=$model->serialNumber->id_serial_numbers?>'><?=$model->serialNumber->devise->devicesType->device_type_name?></span></p>
            <p class='form-row my-1'>Модель устройства - <span id = 'span_devices_model-<?=$model->serialNumber->id_serial_numbers?>'><?=$model->serialNumber->devise->devices_model?></span></p>
        </div>
    </div>
</div>