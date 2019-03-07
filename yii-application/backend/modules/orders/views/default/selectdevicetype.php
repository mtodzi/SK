<?php
//print_r($model_clients) ;

$select = "<select id='search_input_device_type_name-".$id_orders."' size=3 name='' form='' class='select_device_type'>";
    foreach ($model_device_type as $data){        
        $select = $select."<option class='option_device_type_name input_orders_option' data-input-name = 'device_type_name' id='option_device_type_name-".$data->id_device_type."' value = '".$data->id_device_type."'>".$data->device_type_name."</option>";   
    }
$select = $select."</select>";
echo $select;