<?php
//print_r($model_clients) ;

$select = "<select id='search_input_devices_model-".$id_orders."' size=3 name='' form='' class='select_devices_model'>";
    foreach ($model_devices_model as $data){        
        $select = $select."<option class='option_devices_model' id='option_devices_model-".$data->id_devices."' value = '".$data->id_devices."'>".$data->devices_model."</option>";   
    }
$select = $select."</select>";
echo $select;