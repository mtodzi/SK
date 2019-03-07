<?php
//print_r($model_clients) ;

$select = "<select id='search_input_name_brands-".$id_orders."' size=3 name='' form='' class='select_name_brands'>";
    foreach ($model_brend as $data){        
        $select = $select."<option class='option_name_brands input_orders_option' data-input-name = 'name_brands' id='option_name_brands-".$data->id_brands."' value = '".$data->id_brands."'>".$data->name_brands."</option>";   
    }
$select = $select."</select>";
echo $select;