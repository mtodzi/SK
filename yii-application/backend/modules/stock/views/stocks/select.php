<?php
//print_r($model_clients) ;

switch ($data_input_name){
    case 'name_brands':
        $select = "<select id='search_input_name_brands-".$id_serial_numbers."' size=3 name='' form='' class='select_name_brands'>";
        foreach ($model as $data){        
            $select = $select."<option class='option_name_brands input_serial_numbers_option' data-input-name = 'name_brands' id='option_name_brands-".$data->id_brands."' value = '".$data->id_brands."'>".$data->name_brands."</option>";   
        }
        $select = $select."</select>";                
        break;                    
}

echo $select;