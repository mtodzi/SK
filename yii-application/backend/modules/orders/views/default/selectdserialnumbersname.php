<?php
//print_r($model_clients) ;$model_serial_numbers_name

$select = "<select id='search_input_serial_numbers_name-".$id_orders."' size=3 name='' form='' class='select_devices_model'>";
    foreach ($model_serial_numbers_name as $data){        
        $select = $select."<option class='option_serial_numbers_name input_orders_option' data-input-name = 'serial_numbers_name' id='option_serial_numbers_name-".$data->id_serial_numbers."' value = '".$data->id_serial_numbers."'>".$data->serial_numbers_name."</option>";   
    }
$select = $select."</select>";
echo $select;