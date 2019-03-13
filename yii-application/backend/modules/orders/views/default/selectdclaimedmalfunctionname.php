<?php
//print_r($model_clients) ;$model_serial_numbers_name;$model_claimed_malfunction_name

$select = "<select id='search_input_malfunction-".$id_orders."' size=3 name='' form='' class='select_devices_model'>";
    foreach ($model_claimed_malfunction_name as $data){        
        $select = $select."<option class='option_claimed_malfunction_name input_orders_option' data-input-name = 'malfunction' id='option_claimed_malfunction_name-".$data->id_claimed_malfunction."-".$id_malfunction_card."' value = '".$data->id_claimed_malfunction."'>".$data->claimed_malfunction_name."</option>";   
    }
$select = $select."</select>";
echo $select;