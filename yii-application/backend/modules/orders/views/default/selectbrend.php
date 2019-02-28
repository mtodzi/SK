<?php
//print_r($model_clients) ;

$select = "<select id='search_input_brand_name-".$id_orders."' size=3 name='' form='' class='select_brand_name'>";
    foreach ($model_brend as $data){        
        $select = $select."<option class='option_brand_name' id='option_brand_name-".$data->id_brands."' value = '".$data->id_brands."'>".$data->name_brands."</option>";   
    }
$select = $select."</select>";
echo $select;