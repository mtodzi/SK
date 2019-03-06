<?php
//print_r($model_clients) ;

$select = "<select id='search_input_clients_email-".$id_orders."' size=3 name='' form='' class='form-control col-10 select_clients_email' style='margin-left: 30px;'>";
    foreach ($model_clients as $data){        
        $select = $select."<option class='option_clients_email input_orders_option' data-input-name = 'clients_name' id='option_clients_email-".$data->id_clients."' value = '".$data->id_clients."'>".$data->clients_email."</option>";   
    }
$select = $select."</select>";
echo $select;