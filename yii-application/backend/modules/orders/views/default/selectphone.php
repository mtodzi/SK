<?php
//print_r($model_clients) ;

$select = "<select id='search_input_phone_number-".$id_orders."' size=3 name='' form='' class='form-control col-10 select_phone' style='margin-left: 30px;'>";
    foreach ($model_phone as $data){        
        $select = $select."<option class='option_clients_name input_orders_option'  data-input-name = 'clients_name' id='option_clients_name-".$data->clients_id."' value = '".$data->clients_id."'>".$data->phone_number." - ".$data->clients->clients_name."</option>";   
    }
$select = $select."</select>";
echo $select;