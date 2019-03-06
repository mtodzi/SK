<?php
//print_r($model_clients) ;

$select = "<select id='search_input_clients_name-".$id_orders."' size=3 name='' form='' class='form-control col-10 select_clients_name' style='margin-left: 30px;'>";
    foreach ($model_clients as $data){        
        $select = $select."<option class='option_clients_name input_orders_option' data-input-name = 'clients_name' id='option_clients_name-".$data->id_clients."' value = '".$data->id_clients."'>".$data->clients_name."</option>";   
    }
$select = $select."</select>";
echo $select;